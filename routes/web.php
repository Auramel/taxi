<?php

use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('logs', [LogViewerController::class, 'index']);

Route::get('/test', function () {
    $a = config('tg_routes');

    dd($a);
});
