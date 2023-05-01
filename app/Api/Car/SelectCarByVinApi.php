<?php

namespace App\Api\Car;

use App\Api\Api;
use GuzzleHttp\Exception\GuzzleException;

class SelectCarByVinApi extends Api
{
    /**
     * @throws GuzzleException
     */
    public function run(array $parameters): string
    {
        $result = $this->client->post(
            uri: 'https://fleet-api.taxi.yandex.net/v1/parks/cars/list',
            options: [
                'body' => json_encode($parameters),
                'headers' => $this->getHeaders(),
            ],
        );

        $result = json_decode($result->getBody(), JSON_OBJECT_AS_ARRAY);
        $this->data = $result;
        $cars = $result['cars'] ?? [];

        if (
            count($cars) === 0
            || count($cars) > 1
        ) {
            return '';
        }

        $this->data['callsign'] = $cars[0]['callsign'];
        return $cars[0]['id'];
    }
}
