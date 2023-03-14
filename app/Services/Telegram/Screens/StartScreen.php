<?php

namespace App\Services\Telegram\Screens;

use App\Services\Telegram\ScreenResult;
use Auramel\TelegramBotApi\Types\Inline\InlineKeyboardMarkup;

class StartScreen extends Screen
{
    public function index(): ScreenResult
    {
        if (is_null($this->tgUser->driver_id)) {
            $text = 'Для работы с ботом зарегистрируйтесь в парке, Если же вы уже зарегистрированы в парке, то выполните вход по ВУ';
            $buttons = [
                [
                    [
                        'text' => 'Зарегистрироваться',
                        'web_app' => [
                            'url' => $this->url() . '/driver/register',
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
        } else {
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
                        'text' => 'Выбрать смену',
                        'callback_data' => $this->callbackButton(SelectShiftScreen::class),
                    ],
                ],
            ];
        }

        $keyboard = new InlineKeyboardMarkup($buttons);
        $this->sendMessage($text, $keyboard);

        return $this->empty();
    }
}
