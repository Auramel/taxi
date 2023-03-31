<?php

namespace App\Services\Telegram\Screens;

use App\Api\Driver\ChangeBalanceLimitApi;
use App\Services\Telegram\ScreenResult;
use Auramel\TelegramBotApi\Types\Inline\InlineKeyboardMarkup;
use Illuminate\Support\Facades\Log;
use Throwable;

class SelectShiftScreen extends Screen
{
    public function index(): ScreenResult
    {
        $text = 'Операции с лимитом профиля';

        $keyboard = new InlineKeyboardMarkup([
            [
                [
                    'text' => 'Наличная и безналичная оплата',
                    'callback_data' => $this->callbackButton(
                        screen: SelectShiftScreen::class,
                        method: 'changeLimit',
                        data: [
                            'limit' => '10',
                        ],
                    ),
                ],
            ],
            [
                [
                    'text' => 'Безналичная оплата>',
                    'callback_data' => $this->callbackButton(
                        screen: SelectShiftScreen::class,
                        method: 'changeLimit',
                        data: [
                            'limit' => '150000',
                        ],
                    ),
                ],
            ],
            [
                [
                    'text' => 'Вернуться в меню',
                    'callback_data' => $this->callbackButton(StartScreen::class)
                ],
            ],
        ]);

        $this->sendMessage($text, $keyboard);

        return $this->empty();
    }

    public function changeLimit(): ScreenResult
    {
        try {
            $changeBalanceLimitApi = new ChangeBalanceLimitApi();
            $changeBalanceLimitApi->run([
                'driver_id' => $this->tgUser->driver_id,
                'balance_limit' => $this->data['limit'],
            ]);

            $this->sendMessage('Успешно');
        } catch (Throwable $exception) {
            $this->sendMessage($exception->getMessage());
            Log::error($exception);
        }

        return $this->empty();
    }
}
