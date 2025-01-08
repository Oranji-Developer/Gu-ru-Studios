<?php

use App\Http\Controllers\Customer\ChildrenController;
use Illuminate\Support\Facades\Route;

Route::prefix('/user')->middleware(['auth', 'role:customer'])->as('user.')->group(function () {
    Route::resource('/children', ChildrenController::class)->except(['destroy']);
});
