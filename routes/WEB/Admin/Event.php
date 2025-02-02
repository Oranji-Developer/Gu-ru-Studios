<?php

use App\Http\Controllers\Admin\EventController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->middleware(['auth', 'role:admin'])->as('admin.')->group(function () {
    Route::resource('/event', EventController::class)->except('destroy');
});


