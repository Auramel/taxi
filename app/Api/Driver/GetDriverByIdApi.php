<?php

namespace App\Api\Driver;

use App\Api\Api;
use Illuminate\Support\Facades\Log;

class GetDriverByIdApi extends Api
{
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

        return $result['person']['contact_info']['phone'];
    }
}
