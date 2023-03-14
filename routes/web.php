<?php

use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('logs', [LogViewerController::class, 'index']);

Route::get('/test', function () {
    $botApi = new \Auramel\TelegramBotApi\BotApi(env('TELEGRAM_TOKEN'));
    $tgUser = \App\Models\TgUser::whereId(1)
        ->first();

    $botApi->sendMessage($tgUser->tid, 'пидорасина');
});
