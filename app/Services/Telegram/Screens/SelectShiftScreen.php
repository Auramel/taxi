<?php

namespace App\Services\Telegram\Screens;

use App\Api\Driver\ChangeBalanceLimitApi;
use App\Models\Setting;
use App\Services\Telegram\ScreenResult;
use Auramel\TelegramBotApi\Types\Inline\InlineKeyboardMarkup;
use Illuminate\Support\Facades\Log;
use Throwable;

class SelectShiftScreen extends Screen
{
    public function index(): ScreenResult
    {
        $text = 'Операции с лимитом профиля';

        $cardAndCash = ((int) $this->tgUser->card_cash === 0)
            ? null
            : $this->tgUser->card_cash;
        $cash = ((int) $this->tgUser->cash === 0)
            ? null
            : $this->tgUser->cash;

        $keyboard = new InlineKeyboardMarkup([
            [
                [
                    'text' => Setting::cardAndCashPaymentText(),
                    'callback_data' => $this->callbackButton(
                        screen: SelectShiftScreen::class,
                        method: 'changeLimit',
                        data: [
                            'limit' => $cardAndCash ?? Setting::cardAndCashPaymentValue(),
                        ],
                    ),
                ],
            ],
            [
                [
                    'text' => Setting::cashPaymentText(),
                    'callback_data' => $this->callbackButton(
                        screen: SelectShiftScreen::class,
                        method: 'changeLimit',
                        data: [
                            'limit' => $cash ?? Setting::cashPaymentValue(),
                        ],
                    ),
                ],
            ],
            [
                [
                    'text' => Setting::backToMenu(),
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
            $changeBalanceLimitApi = new ChangeBalanceLimitApi($this->tgUser->taxopark);
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
