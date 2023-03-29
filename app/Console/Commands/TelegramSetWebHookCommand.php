<?php

namespace App\Console\Commands;

use Auramel\TelegramBotApi\BotApi;
use Illuminate\Console\Command;

class TelegramSetWebHookCommand extends Command
{
    protected $signature = 'telegram:setwebhook';

    protected $description = 'Command description';

    public function handle(): int
    {
        $token = env('TELEGRAM_TOKEN');
        $api = new BotApi($token);
        $url = env('APP_URL') . '/api/telegram/webhook';

        $this->info('TOKEN: ' . $token);
        $this->info('URL: ' . $url);

        $result = $api->setWebhook($url);

        $this->info('RESULT: ' . $result);

        $api->setMyCommands([
            [
                'command' => '/start',
                'description' => 'Меню',
            ],
        ]);

        return Command::SUCCESS;
    }
}
