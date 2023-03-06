<?php

namespace App\Services\Telegram;

class HashRoute
{
    private string $screen;
    private ?string $method;
    private array $data;

    public static function fromArray(array $data): HashRoute
    {
        return new HashRoute(
            screen: $data['screen'],
            method: $data['method'] ?? null,
            data: $data['data'],
        );
    }

    public function __construct(
        string $screen,
        ?string $method = null,
        array $data = [],
    )
    {
        $this->screen = $screen;
        $this->method = $method;
        $this->data = $data;
    }

    public function getScreen(): string
    {
        return $this->screen;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function toArray(): array
    {
        return [
            'screen' => $this->getScreen(),
            'method' => $this->getMethod(),
            'data' => $this->getData(),
        ];
    }
}
