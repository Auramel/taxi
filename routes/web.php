<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReferralsController;
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

Route::get('/referrals', [ReferralsController::class, 'index'])
    ->name('referrals.list');
Route::get('/referrals/view/{id}', [ReferralsController::class, 'view'])
    ->name('referrals.view');

Route::get('logs', [LogViewerController::class, 'index']);
