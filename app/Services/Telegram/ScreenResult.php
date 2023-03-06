<?php

namespace App\Services\Telegram;

class ScreenResult
{
    public const TYPE_NEXT = 1;
    public const TYPE_REPEAT = 2;
    public const TYPE_EMPTY = 3;
    public const TYPE_REDIRECT = 4;

    private int $type;
    private string $name;
    private ?string $method;
    private array $data;

    public static function fromArray(array $data): ScreenResult
    {
        return new ScreenResult(
            type: $data['type'],
            name: $data['name'],
            method: $data['method'],
            data: $data['data'],
        );
    }

    public static function next(
        string $name,
        ?string $method = null,
        array $data = [],
    ): ScreenResult
    {
        return new ScreenResult(
            type: self::TYPE_NEXT,
            name: $name,
            method: $method,
            data: $data,
        );
    }

    public static function repeat(
        string $name,
        ?string $method = null,
        array $data = [],
    ): ScreenResult
    {
        return new ScreenResult(
            type: ScreenResult::TYPE_REPEAT,
            name: $name,
            method: $method,
            data: $data,
        );
    }

    public static function empty(): ScreenResult
    {
        return new ScreenResult(
            type: ScreenResult::TYPE_EMPTY,
            name: '',
            method: '',
            data: [],
        );
    }

    public static function redirect(
        string $name,
        ?string $method = null,
        array $data = [],
    ): ScreenResult
    {
        return new ScreenResult(
            type: ScreenResult::TYPE_REDIRECT,
            name: $name,
            method: $method,
            data: $data,
        );
    }

    public function __construct(
        int $type,
        string $name,
        ?string $method,
        array $data = [],
    )
    {
        $this->type = $type;
        $this->name = $name;
        $this->method = $method;
        $this->data = $data;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function isNext(): bool
    {
        return $this->getType() === self::TYPE_NEXT;
    }

    public function isRepeat(): bool
    {
        return $this->getType() === self::TYPE_REPEAT;
    }

    public function isEmpty(): bool
    {
        return $this->getType() === self::TYPE_EMPTY;
    }

    public function isRedirect(): bool
    {
        return $this->getType() === self::TYPE_REDIRECT;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getMethod(): ?string
    {
        return $this->method ?? null;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'name' => $this->getName(),
            'method' => $this->getMethod(),
            'data' => $this->getData(),
        ];
    }
}
