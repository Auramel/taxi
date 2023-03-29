<?php

namespace App\Api;

use GuzzleHttp\Client;
use Illuminate\Support\Str;

abstract class Api
{
    protected Client $client;
    protected array $data;

    public function __construct()
    {
        $this->client = new Client();
    }

    abstract public function run(array $parameters): string;

    public function getData(): array
    {
        return $this->data;
    }

    protected function getHeaders(): array
    {
        return [
            'X-Park-ID' => env('PARK_ID'),
            'X-Client-ID' => env('CLIENT_ID'),
            'X-API-Key' => env('API_KEY'),
            'X-Idempotency-Token' => Str::uuid()->toString(),
        ];
    }
}
