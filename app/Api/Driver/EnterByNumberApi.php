<?php

namespace App\Api\Driver;

use App\Api\Api;
use GuzzleHttp\Exception\GuzzleException;

class EnterByNumberApi extends Api
{
    /**
     * @throws GuzzleException
     */
    public function run(array $parameters): string
    {
        $result = $this->client->post(
            uri: 'https://fleet-api.taxi.yandex.net/v1/parks/driver-profiles/list',
            options: [
                'body' => json_encode($parameters),
                'headers' => $this->getHeaders(),
            ],
        );

        $result = json_decode($result->getBody(), JSON_OBJECT_AS_ARRAY);
        $this->data = $result;
        $drivers = $result['driver_profiles'] ?? [];

        if (
            count($drivers) > 1
            || count($drivers) === 0
        ) {
            return '';
        }

        return $drivers[0]['driver_profile']['id'];
    }
}
