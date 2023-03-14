<?php

namespace App\Services\Telegram\Screens;

use App\Api\Driver\EnterByNumberApi;
use App\Services\Telegram\ScreenResult;
use Illuminate\Support\Facades\Log;
use Throwable;

class EnterByNumberScreen extends Screen
{
    public function index(): ScreenResult
    {
        $message = $this->getCommandValue();

        if (is_null($message)) {
            $this->sendMessage('Введите ваше ВУ в формате: 12 12 123456');
            return $this->repeat();
        }

        try {
            $parameters = [
                'query' => [
                    'text' => $message,
                    'park' => [
                        'id' => env('PARK_ID'),
                    ],
                ],
            ];

            $enterByNumberApi = new EnterByNumberApi();
            $driverId = $enterByNumberApi->run($parameters);

            if (empty($driverId)) {
                $this->sendMessage('Профль не найден. Попробуйте снова');
                return $this->repeat();
            }

            $this->tgUser->driver_id = $driverId;
            $this->tgUser->save();

            $this->sendMessage('Ваш профиль сохранен');

            $startScreen = new StartScreen(
                tgUser: $this->tgUser,
                botApi: $this->botApi,
                payload: $this->payload,
            );

            $startScreen->index();
        } catch (Throwable $exception) {
            $this->sendMessage($exception->getMessage());
            Log::error($exception);
        }

        return $this->repeat();
    }
}
