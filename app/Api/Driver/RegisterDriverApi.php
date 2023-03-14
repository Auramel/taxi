<?php

namespace App\Api\Driver;

use App\Api\Api;
use GuzzleHttp\Exception\GuzzleException;

class RegisterDriverApi extends Api
{
    /**
     * @throws GuzzleException
     */
    public function run(array $parameters): string
    {
        $result = $this->client->post(
            uri: 'https://fleet-api.taxi.yandex.net/v2/parks/contractors/driver-profile',
            options: [
                'body' => json_encode($parameters),
                'headers' => $this->getHeaders(),
            ],
        );

        $result = json_decode($result->getBody(), JSON_OBJECT_AS_ARRAY);

        return $result['contractor_profile_id'];
    }
}
