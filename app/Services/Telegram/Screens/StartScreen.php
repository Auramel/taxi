<?php

namespace App\Services\Telegram\Screens;

use App\Api\Driver\GetDriverByIdApi;
use App\Models\Setting;
use App\Models\Taxopark;
use App\Services\Telegram\ScreenResult;
use Auramel\TelegramBotApi\Types\Inline\InlineKeyboardMarkup;
use Auramel\TelegramBotApi\Types\ReplyKeyboardMarkup;
use Illuminate\Support\Facades\Log;
use Throwable;

class StartScreen extends Screen
{
    public function index(): ScreenResult
    {
        if (is_null($this->tgUser->taxopark)) {
            return $this->selectTaxoPark();
        } elseif (is_null($this->tgUser->driver_id)) {
            return $this->login();
        } elseif (is_null($this->tgUser->phone)) {
            return $this->requestContact();
        }

        return $this->menu();
    }

    public function login(): ScreenResult
    {
        $brand = env('BRAND');

        if ($brand === 'ufaremzona') {
            $registerButton = [
                'text' => Setting::registerButtonText(),
                'web_app' => [
                    'url' => 'https://forms.taxiaggregator.ru/add-drivers?uid=0d49c134-565c-4f48-ac04-8f2e1380156b&s=5',
                ],
            ];
        } elseif ($brand === 'taxibotufa02') {
            $registerButton = [
                'text' => Setting::registerButtonText(),
                'url' => 'http://wa.me/79870253005',
            ];
        } else {
            $registerButton = [
                'text' => Setting::registerButtonText(),
                'url' => 'https://wa.me/79270390705',
            ];
        }

        $text = Setting::loginText();
        $buttons = [
            [
                $registerButton,
            ],
            [
                [
                    'text' => Setting::loginByNumberButtonText(),
                    'callback_data' => $this->callbackButton(EnterByNumberScreen::class),
                ],
            ],
        ];

        $keyboard = new InlineKeyboardMarkup($buttons);
        $this->sendMessage($text, $keyboard);

        return $this->empty();
    }

    public function menu(): ScreenResult
    {
        $text = 'Привет, ' . $this->tgUser->first_name . '!' . PHP_EOL;
        $text .= Setting::menuText();

        $buttons = [
            [
                [
                    'text' => Setting::addCarButtonText(),
                    'web_app' => [
                        'url' => $this->url() . '/car/register',
                    ],
                ],
                [
                    'text' => Setting::selectCarButtonText(),
                    'callback_data' => $this->callbackButton(LinkCarToDriverScreen::class),
                ],
            ],
            [
                [
                    'text' => Setting::selectPaymentButtonText(),
                    'callback_data' => $this->callbackButton(SelectShiftScreen::class),
                ],
            ],
        ];

        if ($this->tgUser->has_debt === 1) {
            $buttons[] = [
                [
                    'text' => Setting::shiftDebtPaymentText(),
                    'callback_data' => $this->callbackButton(
                        screen: SelectShiftScreen::class,
                        method: 'changeLimit',
                        data: [
                            'limit' => Setting::shiftDebtPaymentValue(),
                        ],
                    ),
                ],
            ];
        }

        $keyboard = new InlineKeyboardMarkup($buttons);
        $this->sendMessage($text, $keyboard);

        return $this->empty();
    }

    public function requestContact(): ScreenResult
    {
        $keyboard = new ReplyKeyboardMarkup(
            keyboard: [
                [
                    [
                        'text' => Setting::sendMyContactText(),
                        'request_contact' => true,
                    ],
                ],
            ],
            oneTimeKeyboard: true,
            resizeKeyboard: true,
        );

        $this->sendMessage(Setting::requestContactText(), $keyboard);

        return $this->next(
            self::class,
            'verifyContact',
        );
    }

    public function verifyContact(): ScreenResult
    {
        try {
            $parameters = [
                'driver_id' => $this->tgUser->driver_id,
            ];

            $api = new GetDriverByIdApi($this->tgUser->taxopark);
            $phone = (int) $api->run($parameters);

            $phonePosition = strpos($phone, '9');
            $phone = substr($phone, $phonePosition);

            $message = $this->payload->getMessage();
            $contact = $message->getContact();

            $contactPhone = (int) $contact->getPhoneNumber();
            $contactPhonePosition = strpos($contactPhone, '9');
            $contactPhone = substr($contactPhone, $contactPhonePosition);

            if (
                $contact->getUserId() !== $this->tgUser->tid
                || $contactPhone !== $phone
            ) {
                $this->sendMessage(Setting::phoneNotEqualText());
                return $this->empty();
            }

            $this->tgUser->phone = $phone;
            $this->tgUser->save();

            $this->sendMessage(Setting::phoneSavedText());

            return $this->index();
        } catch (Throwable $exception) {
            $this->sendMessage($exception->getMessage());
            Log::error($exception);
        }

        return $this->empty();
    }

    public function selectTaxopark(): ScreenResult
    {
        $buttons = [];
        $taxoparks = Taxopark::get();

        foreach ($taxoparks as $taxopark) {
            $buttons[] = [
                [
                    'text' => $taxopark->name,
                    'callback_data' => $this->callbackButton(
                        screen: StartScreen::class,
                        method: 'selectTaxopark_',
                        data: [
                            'id' => $taxopark->id,
                        ],
                    )
                ],
            ];
        }

        $keyboard = new InlineKeyboardMarkup($buttons);
        $this->sendMessage(Setting::selectTaxoparkText(), $keyboard);
        return $this->empty();
    }

    public function selectTaxopark_(): ScreenResult
    {
        $taxoparkId = $this->data['id'];
        $this->tgUser->taxopark_id = $taxoparkId;
        $this->tgUser->save();

        $keyboard = new InlineKeyboardMarkup([
            [
                [
                    'text' => Setting::backToMenu(),
                    'callback_data' => $this->callbackButton(StartScreen::class),
                ],
            ],
        ]);

        $this->sendMessage(Setting::taxoparkSavedText(), $keyboard);
        return $this->next(StartScreen::class);
    }
}
