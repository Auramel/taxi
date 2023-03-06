<?php

namespace App\Services\Telegram\Screens;

use App\Models\TgHashRoute;
use App\Models\TgUser;
use App\Services\Telegram\HashRoute;
use App\Services\Telegram\ScreenResult;
use Auramel\TelegramBotApi\BotApi;
use Auramel\TelegramBotApi\Types\Inline\InlineKeyboardMarkup;
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
        int $screenId,
        ?string $method = null,
    ): ScreenResult
    {
        return ScreenResult::next(
            name: static::class,
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
        int $screenId,
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
        ?InlineKeyboardMarkup $keyboard = null,
    )
    {
        $this->botApi->sendMessage(
            chatId: $this->tgUser->tid,
            text: $message,
            replyMarkup: $keyboard,
        );
    }
}
