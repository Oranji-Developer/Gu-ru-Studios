<?php

use App\Http\Controllers\Customer\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'verified', 'profiled']], function () {

    Route::prefix('settings')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/account', [ProfileController::class, 'editAccount'])->name('account.edit');
        Route::patch('/account', [ProfileController::class, 'updateAccount'])->name('account.update');
    });

});
