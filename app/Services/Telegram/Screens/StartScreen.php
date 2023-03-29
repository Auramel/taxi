<?php

namespace App\Services\Telegram\Screens;

use App\Api\Driver\GetDriverByIdApi;
use App\Services\Telegram\ScreenResult;
use Auramel\TelegramBotApi\Types\Inline\InlineKeyboardMarkup;
use Auramel\TelegramBotApi\Types\ReplyKeyboardMarkup;
use Illuminate\Support\Facades\Log;
use Throwable;

class StartScreen extends Screen
{
    public function index(): ScreenResult
    {
        if (is_null($this->tgUser->driver_id)) {
            return $this->login();
        } elseif (is_null($this->tgUser->phone)) {
            return $this->requestContact();
        }

        return $this->menu();
    }

    public function login(): ScreenResult
    {
        $text = 'Для работы с ботом зарегистрируйтесь в парке. Если Вы уже зарегистрированы в парке, то выполните вход по ВУ. После регистрации необходимо выполнить вход по ВУ';
        $buttons = [
            [
                [
                    'text' => 'Зарегистрироваться',
                    'web_app' => [
                        'url' => 'https://forms.taxiaggregator.ru/add-drivers?uid=0d49c134-565c-4f48-ac04-8f2e1380156b&s=5',
                    ],
                ],
            ],
            [
                [
                    'text' => 'Войти по ВУ',
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
        $text = 'Привет, ' . $this->tgUser->first_name .'!' . PHP_EOL;
        $text .= 'Для навигации используй кнопки ниже:';

        $buttons = [
            [
                [
                    'text' => 'Реферальная программа',
                    'callback_data' => $this->callbackButton(ReferralProgramScreen::class),
                ],
            ],
            [
                [
                    'text' => 'Добавить авто',
                    'web_app' => [
                        'url' => $this->url() . '/car/register',
                    ],
                ],
                [
                    'text' => 'Выбрать авто',
                    'callback_data' => $this->callbackButton(LinkCarToDriverScreen::class),
                ],
            ],
            [
                [
                    'text' => 'Выбрать тип оплаты',
                    'callback_data' => $this->callbackButton(SelectShiftScreen::class),
                ],
            ],
            [
                [
                    'text' => 'Купить смену',
                    'callback_data' => $this->callbackButton(
                        screen: SelectShiftScreen::class,
                        method: 'changeLimit',
                        data: [
                            'limit' => '-800',
                        ],
                    ),
                ],
            ],
        ];

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
                        'text' => 'Отправить мои данные',
                        'request_contact' => true,
                    ],
                ],
            ],
            oneTimeKeyboard: true,
            resizeKeyboard: true,
        );

        $this->sendMessage('Пришлите ваш контакт для подтверждения вашей личности', $keyboard);

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

            $api = new GetDriverByIdApi();
            $phone = (int) $api->run($parameters);

            $this->sendMessage('Яндекс: ' . $phone);

            $phonePosition = strpos($phone, '9');
            $phone = substr($phone, $phonePosition);

            $message = $this->payload->getMessage();
            $contact = $message->getContact();

            $contactPhone = (int) $contact->getPhoneNumber();
            $this->sendMessage('Telegram: ' . $contactPhone);
            $contactPhonePosition = strpos($contactPhone, '9');
            $contactPhone = substr($contactPhone, $contactPhonePosition);

            if (
                $contact->getUserId() !== $this->tgUser->tid
                || $contactPhone !== $phone
            ) {
                $this->sendMessage('Ваш номер не совпадает с номером указанным в Яндексе. Свяжитесь с менеджером для обновления информации и повторите снова.');
                return $this->empty();
            }

            $this->tgUser->phone = $phone;
            $this->tgUser->save();

            $this->sendMessage('Данные успешно подтверждены.');

            return $this->index();
        } catch (Throwable $exception) {
            $this->sendMessage($exception->getMessage());
            Log::error($exception);
        }

        return $this->empty();
    }
}
