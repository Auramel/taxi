<?php

namespace App\Api;

class SmsApi extends Api
{
    public function run(array $parameters): string
    {
        $phone = $parameters['phone'];
        $message = $parameters['message'];
        $key = env('SMS_KEY');

        $url = 'http://crm.smsvizitka.com/api/send-sms?api_key='. $key .'&to=' . $phone . '&text=' . $message;
        $this->client->get($url)->getBody();

        return '';
    }
}
