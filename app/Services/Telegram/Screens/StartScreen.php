<?php

namespace App\Services\Telegram\Screens;

use App\Services\Telegram\ScreenResult;

class StartScreen extends Screen
{
    public function index(): ScreenResult
    {
        $this->sendMessage('hello');

        return $this->empty();
    }
}
