<?php

namespace App\Services\Telegram\Screens;

use App\Services\Telegram\ScreenResult;
use Auramel\TelegramBotApi\Exception;
use Auramel\TelegramBotApi\InvalidArgumentException;

class ReferralProgramScreen extends Screen
{
    /**
     * @throws Exception
     * @throws InvalidArgumentException
     */
    public function index(): ScreenResult
    {
        $me = $this->botApi->getMe();
        $url = 'https://t.me/' . $me->getUsername() . '?start=' . $this->tgUser->referral_hash;

        $text = '👥 Реферальная программа
🔗 Ваша реферальная ссылка: ' . $url . '
        ';

        $this->sendMessage($text);

        return $this->empty();
    }
}
