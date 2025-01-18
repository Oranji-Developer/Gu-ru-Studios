<?php

use App\Http\Controllers\Admin\UserCourseController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->middleware(['auth', 'role:admin'])->as('admin.')->group(function () {
    Route::resource('/invoice', UserCourseController::class)->except(['show', 'create', 'store', 'destroy']);
});
