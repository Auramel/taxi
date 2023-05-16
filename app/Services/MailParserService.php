<?php

namespace App\Services;

use App\Api\Driver\EnterByNumberApi;
use App\Mail\DemoEmail;
use App\Models\Setting;
use App\Models\Taxopark;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Webklex\IMAP\Facades\Client;
use Webklex\PHPIMAP\Folder;
use Webklex\PHPIMAP\Message;
use Webklex\PHPIMAP\Support\MessageCollection;

class MailParserService
{
    private \Webklex\PHPIMAP\Client $client;

    private EnterByNumberApi $enterByNumberApi;

    private array $strings = [
        'driver' => [
            'openAccess' => [
                'first' => 'Водитель (ВУ:',
                'last' => 'может вернуться к заказам',
            ],
            'closeAccess' => [
                'first' => 'Водителю (ВУ:',
                'last' => 'ограничен доступ к заказам',
            ],
            'payRequest' => [
                'first' => 'Запрос на подключение выплат водителю',
            ],
            'wantWork' => [
                'first' => 'Новый водитель хочет работать в вашем таксопарке',
            ],
            'new' => [
                'first' => 'Новый водитель подключился в ваш таксопарк',
            ],
        ],
        'car' => [
            'openAccess' => [
                'first' => 'Автомобилю с госномером',
                'last' => 'вернули доступ к заказам',
            ],
            'closeAccess' => [
                'first' => 'Автомобилю с госномером',
                'last' => 'ограничен доступ к заказам',
            ],
        ],
    ];

    public function __construct()
    {
        $this->client = Client::account('default');
        $this->enterByNumberApi = new EnterByNumberApi(Taxopark::default());
    }

    public function parseMessages(): MessageCollection
    {
        $config = $this->client->getConfig();

        $config['host'] = Setting::hostParse();
        $config['port'] = Setting::portParse();
        $config['username'] = Setting::usernameParse();
        $config['password'] = Setting::passwordParse();
        $config['protocol'] = Setting::protocolParse();

        $this->client->setConfig($config);
        $this->client->connect();
        $folders = $this->client->getFolders();

        /** @var Folder $folder */
        $folder = $folders[1];
        $messages = $folder->messages()->all()->get();

        /** @var Message $message */
        foreach ($messages as $message) {
            $flags = $message->getFlags();

//            if (!$flags->isEmpty()) {
//                continue;
//            }

            $this->parseMessage($message);
        }

        return $messages;
    }

    public function parseMessage(Message $message): void
    {
        $title = $message->getSubject()->toString();

        if (
            (
                str_contains($title, $this->strings['driver']['openAccess']['first'])
                && str_contains($title, $this->strings['driver']['openAccess']['last'])
            )
            || (
                str_contains($title, $this->strings['driver']['closeAccess']['first'])
                && str_contains($title, $this->strings['driver']['closeAccess']['last'])
            )
        ) {
            $this->driverChangeAccess($message);
        } elseif (str_contains($title, $this->strings['driver']['payRequest']['first'])) {
            $this->driverPayRequest($message);
        } elseif (str_contains($title, $this->strings['driver']['wantWork']['first'])) {
            $this->driverPayRequest($message);
        } elseif (str_contains($title, $this->strings['driver']['new']['first'])) {
            $this->driverNew($message);
        } else {
            return;
        }

        $message->setFlag('SEEN');
        $this->client->expunge();
    }

    private function driverChangeAccess(Message $message): void
    {
        $title = $message->getSubject()->toString();
        $driverPassport = filter_var($title, FILTER_SANITIZE_NUMBER_INT);

        $parameters = [
            'query' => [
                'text' => $driverPassport,
                'park' => [
                    'id' => env('PARK_ID'),
                ],
            ],
        ];

        $this->enterByNumberApi->run($parameters);
        $data = $this->enterByNumberApi->getData();
        $driverProfiles = $data['driver_profiles'] ?? [];

        if (empty($driverProfiles)) {
            return;
        }

        $driverProfile = $driverProfiles[0];
        $phones = $driverProfile['driver_profile']['phones'] ?? [];
        $lastPhone = end($phones);
        $fio = ($driverProfile['driver_profile']['last_name'] ?? '')
            . ' '
            . ($driverProfile['driver_profile']['first_name'] ?? '')
            . ' '
            . ($driverProfile['driver_profile']['middle_name']);

        $this->sendMessage(
            phone: $lastPhone,
            fio: $fio,
            message: $title,
        );
    }

    private function driverPayRequest(Message $message): void
    {
        $text = $message->getHTMLBody();

        preg_match_all('@[^a-zA-Z]{7,}@is', $text, $matches);
        $matches = $matches[0];

        foreach ($matches as $key => $match) {
            $matches[$key] = preg_replace('@[^0-9]@s', '', $match);
        }

        $matches = array_filter($matches, function ($item) {
            return !empty($item);
        });

        $phone = array_shift($matches);
        $phone = '+7' . $phone;

        $this->sendMessage(
            phone: $phone,
            fio: '',
            message: strip_tags($text),
        );
    }

    public function driverNew(Message $message): void
    {
        $text = strip_tags($message->getHTMLBody());
        $regex = '/\b[A-ZА-Я][a-zа-я]+\s[A-ZА-Я][a-zа-я]+\s[A-ZА-Я][a-zа-я]+\b/u';
        preg_match($regex, $text, $match);
        $fio = $match[0] ?? null;

        if (is_null($fio)) {
            return;
        }

        $parameters = [
            'query' => [
                'text' => $fio,
                'park' => [
                    'id' => Taxopark::default()->park_id,
                ],
            ],
        ];

        $this->enterByNumberApi->run($parameters);

        $data = $this->enterByNumberApi->getData();
        $driverProfiles = $data['driver_profiles'] ?? [];

        if (empty($driverProfiles)) {
            return;
        }

        $driverProfile = $driverProfiles[0];
        $phones = $driverProfile['driver_profile']['phones'] ?? [];
        $lastPhone = end($phones);

        $this->sendMessage(
            phone: $lastPhone,
            fio: $fio,
            message: $text,
        );
    }

    public static function sendMessage(
        string $phone,
        string $fio,
        string $message,
    ): void
    {
        $mail = Setting::mailTo();

        $config = Config::get('mail');
        $config['mailers']['smtp']['host'] = Setting::hostSend();
        $config['mailers']['smtp']['port'] = Setting::portSend();
        $config['mailers']['smtp']['username'] = Setting::usernameSend();
        $config['mailers']['smtp']['password'] = Setting::passwordSend();
        $config['mailers']['smtp']['transport'] = Setting::protocolSend();

        Config::set('mail', $config);

        Mail::to($mail)->send(new DemoEmail(
            phone: $phone,
            fio: $fio,
            message: $message,
        ));
    }
}
