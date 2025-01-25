<?php

use App\Http\Controllers\Admin\MentorController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->middleware(['auth', 'role:admin'])->as('admin.')->group(function () {
    Route::resource('/mentor', MentorController::class)->except(['show']);
});
