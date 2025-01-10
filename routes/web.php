<?php

use App\Http\Controllers\Customer\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::group(['middleware' => ['auth', 'verified', 'profiled']], function () {
    Route::get('/dashboard', function () {
        return Inertia::render('DashboardRole');
    })->name('dashboard');

    //just for test
    Route::get('/product', [ProfileController::class, 'show'])->name('product');
});
