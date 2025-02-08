<?php

use App\Http\Controllers\Customer\TestimoniesController;
use Illuminate\Support\Facades\Route;

Route::prefix('/user')->middleware(['auth', 'role:customer'])->as('user.')->group(function () {
    Route::resource('/testimony', TestimoniesController::class)->except(['index', 'create', 'show', 'edit', 'destroy']);
});
