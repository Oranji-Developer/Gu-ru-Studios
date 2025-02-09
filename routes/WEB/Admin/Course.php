<?php

use App\Http\Controllers\Admin\CourseController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->middleware(['auth', 'role:admin'])->as('admin.')->group(function () {
    Route::resource('/course', CourseController::class);
});
