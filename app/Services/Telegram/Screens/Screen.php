<?php

namespace App\Services\Telegram\Screens;

use App\Models\TgHashRoute;
use App\Models\TgUser;
use App\Services\Telegram\HashRoute;
use App\Services\Telegram\ScreenResult;
use Auramel\TelegramBotApi\BaseType;
use Auramel\TelegramBotApi\BotApi;
use Auramel\TelegramBotApi\Types\Update;

abstract class Screen
{
    protected TgUser $tgUser;
    protected BotApi $botApi;
    protected Update $payload;
    protected array $data;

    public function __construct(
        TgUser $tgUser,
        BotApi $botApi,
        Update $payload,
        array $data = [],
    )
    {
        $this->tgUser = $tgUser;
        $this->botApi = $botApi;
        $this->payload = $payload;
        $this->data = $data;
    }

    abstract public function index(): ScreenResult;

    public function callbackButton(
        string $screen,
        ?string $method = null,
        array $data = [],
    ): string
    {
        $hashRoute = new HashRoute(
            screen: $screen,
            method: $method,
            data: $data,
        );

        $data = json_encode($hashRoute->toArray());
        $hash = md5($data);

        $tgHashRoute = TgHashRoute::whereHash($hash)
            ->first();

        if (is_null($tgHashRoute)) {
            $tgHashRoute = new TgHashRoute();
            $tgHashRoute->data = $data;
            $tgHashRoute->hash = $hash;
            $tgHashRoute->save();
        }

        return $tgHashRoute->hash;
    }

    public function next(
        string $screen,
        ?string $method = null,
    ): ScreenResult
    {
        return ScreenResult::next(
            name: $screen,
            method: $method,
            data: $this->data,
        );
    }

    public function repeat(?string $method = null): ScreenResult
    {
        return ScreenResult::repeat(
            name: static::class,
            method: $method,
            data: $this->data,
        );
    }

    public function empty(): ScreenResult
    {
        return ScreenResult::empty();
    }

    public function redirect(
        string $screen,
        ?string $method = null,
        array $data = []
    ): ScreenResult
    {
        return ScreenResult::redirect(
            name: $screen,
            method: $method,
            data: $data,
        );
    }

    protected function sendMessage(
        string $message,
        ?BaseType $keyboard = null,
    )
    {
        $this->botApi->sendMessage(
            chatId: $this->tgUser->tid,
            text: $message,
            parseMode: 'html',
            replyMarkup: $keyboard,
        );
    }

    protected function url(): string
    {
        return env('APP_URL') . '/webapp';
    }

    protected function getCommandValue(): ?string
    {
        $json = json_decode($this->payload->getMessage()?->toJson(), JSON_OBJECT_AS_ARRAY);

        if (is_null($json)) {
            return null;
        }

        $message = $this->payload->getMessage()->getText();

        if ($message[0] === '/') {
            $result = substr($message, $json['entities'][0]['length']);
        } else {
            $result = $message;
        }

        return (strlen($result) > 0)
            ? $result
            : null;
    }
}
