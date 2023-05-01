<?php

namespace App\Api;

use App\Models\Taxopark;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

abstract class Api
{
    protected Client $client;
    protected array $data;
    protected Taxopark $taxopark;

    public function __construct(Taxopark $taxopark)
    {
        $this->client = new Client();
        $this->taxopark = $taxopark;
    }

    abstract public function run(array $parameters): string;

    public function getData(): array
    {
        return $this->data;
    }

    protected function getHeaders(): array
    {
        return [
            'X-Park-ID' => $this->taxopark->park_id,
            'X-Client-ID' => $this->taxopark->client_id,
            'X-API-Key' => $this->taxopark->api_key,
            'X-Idempotency-Token' => Str::uuid()->toString(),
        ];
    }
}
