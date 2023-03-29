<?php

namespace App\Services\Telegram\Screens;

use App\Api\Car\LinkCarToDriverApi;
use App\Api\Car\SelectCarByVinApi;
use App\Models\Car;
use App\Services\Telegram\ScreenResult;
use Illuminate\Support\Facades\Log;
use Throwable;

class LinkCarToDriverScreen extends Screen
{
    public function index(): ScreenResult
    {
        $message = $this->getCommandValue();

        if (is_null($message)) {
            $this->sendMessage('Введите VIN код автомобиля');
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

            $selectCarByVinApi = new SelectCarByVinApi();
            $carId = $selectCarByVinApi->run($parameters);

            if (empty($carId)) {
                $this->sendMessage('Авто не найдено. Попробуйте снова');
                return $this->repeat();
            }

            $this->sendMessage($this->tgUser->driver_id);

            $linkCarToDriverApi = new LinkCarToDriverApi();
            $linkCarToDriverApi->run([
                'car_id' => $carId,
                'driver_id' => $this->tgUser->driver_id,
            ]);

            $car = Car::whereCarId($carId)
                ->whereTgUserId($this->tgUser->id)
                ->first();

            if (is_null($car)) {
                $car = new Car();
                $car->car_id = $carId;
                $car->tg_user_id = $this->tgUser->id;
                $car->callsign = $selectCarByVinApi->getData()['callsign'];
                $car->save();
            }

            $this->sendMessage('Авто выбрано');
        } catch (Throwable $exception) {
            $this->sendMessage($exception->getMessage());
            Log::error($exception);
        }

        return $this->empty();
    }
}
