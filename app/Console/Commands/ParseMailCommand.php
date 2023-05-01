<?php

namespace App\Console\Commands;

use App\Services\MailParserService;
use Illuminate\Console\Command;

class ParseMailCommand extends Command
{
    protected $signature = 'mail:parse';

    protected $description = 'Parsing email';

    public function handle(): int
    {
        (new MailParserService)->parseMessages();

        return Command::SUCCESS;
    }
}
