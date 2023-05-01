<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ParserController;
use App\Http\Controllers\ReferralsController;
use App\Http\Controllers\TaxoparksController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\CheckUserMiddleware;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

Route::get('/', function () {
    throw new NotFoundHttpException();
})->withoutMiddleware(CheckUserMiddleware::class);

Route::get('/auth/login', [AuthController::class, 'login'])
    ->name('auth.login')
    ->withoutMiddleware(CheckUserMiddleware::class);
Route::post('/auth/login', [AuthController::class, 'login_'])
    ->name('auth.login_')
    ->withoutMiddleware(CheckUserMiddleware::class);

Route::get('/users', [UsersController::class, 'index'])
    ->name('users.list');
Route::get('/users/view/{id}', [UsersController::class, 'view'])
    ->name('users.view');
Route::get('/users/view/{id}/ban', [UsersController::class, 'ban'])
    ->name('users.ban');
Route::get('/users/view/{id}/unban', [UsersController::class, 'unban'])
    ->name('users.unban');
Route::get('/users/delete/{id}', [UsersController::class, 'delete'])
    ->name('users.delete');
Route::get('/users/reset/phone/{id}', [UsersController::class, 'resetPhone'])
    ->name('users.reset.phone');
Route::get('/users/reset/yandex/{id}', [UsersController::class, 'resetYandexId'])
    ->name('users.reset.yandex');
Route::get('/users/{id}/debt/{hasDebt}', [UsersController::class, 'changeHasDebt'])
    ->name('users.debt');

Route::get('/referrals', [ReferralsController::class, 'index'])
    ->name('referrals.list');
Route::get('/referrals/view/{id}', [ReferralsController::class, 'view'])
    ->name('referrals.view');

Route::get('/taxoparks', [TaxoparksController::class, 'index'])
    ->name('taxoparks.list');
Route::get('/taxoparks/create', [TaxoparksController::class, 'create'])
    ->name('taxoparks.create');
Route::post('/taxoparks/create', [TaxoparksController::class, 'create_'])
    ->name('taxoparks.create_');
Route::get('/taxoparks/view/{id}', [TaxoparksController::class, 'view'])
    ->name('taxoparks.view');
Route::post('/taxoparks/view/{id}', [TaxoparksController::class, 'view_'])
    ->name('taxoparks.view_');
Route::get('/taxoparks/delete/{id}', [TaxoparksController::class, 'delete'])
    ->name('taxoparks.delete');

Route::get('logs', [LogViewerController::class, 'index'])
    ->withoutMiddleware(CheckUserMiddleware::class);

Route::get('/parse', [ParserController::class, 'index'])
    ->name('parser.list');
