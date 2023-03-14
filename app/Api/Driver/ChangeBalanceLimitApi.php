<?php

namespace App\Api\Driver;

use App\Api\Api;
use GuzzleHttp\Exception\GuzzleException;

class ChangeBalanceLimitApi extends Api
{
    /**
     * @throws GuzzleException
     */
    public function run(array $parameters): string
    {
        $driverId = $parameters['driver_id'];

        $result = $this->client->get(
            uri: 'https://fleet-api.taxi.yandex.net/v2/parks/contractors/driver-profile?contractor_profile_id=' . $driverId,
            options: [
                'headers' => $this->getHeaders(),
            ],
        );

        $result = json_decode($result->getBody(), JSON_OBJECT_AS_ARRAY);
        $result['account']['balance_limit'] = (string) $parameters['balance_limit'];

        $this->client->put(
            uri: 'https://fleet-api.taxi.yandex.net/v2/parks/contractors/driver-profile?contractor_profile_id=' . $driverId,
            options: [
                'body' => json_encode($result),
                'headers' => $this->getHeaders(),
            ],
        );

        return '';
    }
}
