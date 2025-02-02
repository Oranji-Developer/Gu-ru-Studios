<?php

use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\GlobalController;
use App\Models\Course;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [GlobalController::class, 'home'])->name('home');
Route::get('/courses', [GlobalController::class, 'courses'])->name('courses');

Route::group(['middleware' => ['auth', 'verified', 'profiled']], function () {
    Route::get('/dashboard', function () {
        return Inertia::render('DashboardRole');
    })->name('dashboard');

    //just for test
    Route::get('/product', [ProfileController::class, 'show'])->name('product');
});
