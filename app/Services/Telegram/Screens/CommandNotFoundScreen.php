<?php

namespace App\Services\Telegram\Screens;

use App\Services\Telegram\ScreenResult;

class CommandNotFoundScreen extends Screen
{
    public function index(): ScreenResult
    {
        $this->sendMessage('Команда не найдена');

        return $this->empty();
    }
}
