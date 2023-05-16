<?php

namespace App\Services\Telegram\Screens;

use App\Api\Driver\EnterByNumberApi;
use App\Models\Setting;
use App\Services\Telegram\ScreenResult;
use Illuminate\Support\Facades\Log;
use Throwable;

class EnterByNumberScreen extends Screen
{
    public function index(): ScreenResult
    {
        $message = $this->getCommandValue();

        if (is_null($message)) {
            $this->sendMessage(Setting::requestNumberText());
            return $this->repeat();
        }

        try {
            $parameters = [
                'query' => [
                    'text' => $message,
                    'park' => [
                        'id' => $this->tgUser->taxopark->park_id,
                    ],
                ],
            ];

            $enterByNumberApi = new EnterByNumberApi($this->tgUser->taxopark);
            $driverId = $enterByNumberApi->run($parameters);

            if (empty($driverId)) {
                $this->sendMessage(Setting::driverNotFoundText());
                return $this->repeat();
            }

            $this->tgUser->driver_id = $driverId;
            $this->tgUser->save();

            $this->sendMessage(Setting::driverSavedText());

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
