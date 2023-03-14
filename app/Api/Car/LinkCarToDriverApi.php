<?php

namespace App\Api\Car;

use App\Api\Api;
use GuzzleHttp\Exception\GuzzleException;

class LinkCarToDriverApi extends Api
{
    /**
     * @throws GuzzleException
     */
    public function run(array $parameters): string
    {
        $carId = $parameters['car_id'];
        $driverId = $parameters['driver_id'];

        $this->client->put(
            uri: 'https://fleet-api.taxi.yandex.net/v1/parks/driver-profiles/car-bindings?park_id=' . env('PARK_ID') . '&car_id=' . $carId . '&driver_profile_id=' . $driverId,
            options: [
                'headers' => $this->getHeaders(),
            ],
        );

        return '';
    }
}
