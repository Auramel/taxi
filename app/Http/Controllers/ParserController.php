<?php

namespace App\Http\Controllers;

use App\Services\MailParserService;
use Illuminate\View\View;

class ParserController extends Controller
{
    private MailParserService $mailParserService;

    public function __construct(MailParserService $mailParserService)
    {
        $this->mailParserService = $mailParserService;
    }

    public function index(): View
    {
        $messages = $this->mailParserService->parseMessages();

        return view('parser.list', [
            'messages' => $messages,
        ]);
    }
}
