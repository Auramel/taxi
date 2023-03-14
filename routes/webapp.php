<?php

use App\Http\Controllers\WebApp\Car\RegisterCarController;
use App\Http\Controllers\WebApp\Driver\RegisterDriverController;
use Illuminate\Support\Facades\Route;

Route::prefix('/car')
    ->name('car.')
    ->group(function () {
        Route::get('/register', [RegisterCarController::class, 'view'])->name('register');
        Route::post('/register', [RegisterCarController::class, 'register'])->name('register_');
    });

Route::prefix('/driver')
    ->name('driver.')
    ->group(function () {
        Route::get('/register', [RegisterDriverController::class, 'view'])->name('register');
        Route::post('/register', [RegisterDriverController::class, 'register'])->name('register_');
    });

Route::get('/error', function () {
    return view('webapp.error');
})->name('error');

Route::get('/success', function () {
    return view('webapp.success');
})->name('success');
