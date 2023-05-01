<?php

namespace App\Services;

use App\Api\Driver\EnterByNumberApi;
use App\Mail\DemoEmail;
use App\Models\Taxopark;
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
        $this->client->connect();
        $folders = $this->client->getFolders();

        /** @var Folder $folder */
        $folder = $folders[1];
        $messages = $folder->messages()->all()->get();

        /** @var Message $message */
        foreach ($messages as $message) {
            $flags = $message->getFlags();

            if (!$flags->isEmpty()) {
                continue;
            }

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

    private function sendMessage(
        string $phone,
        string $fio,
        string $message,
    ): void
    {
        Mail::to(env('MAIL_1'))->send(new DemoEmail(
            phone: $phone,
            fio: $fio,
            message: $message,
        ));
    }
}
