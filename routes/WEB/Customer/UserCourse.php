<?php

use App\Http\Controllers\Customer\UserCourseController;
use Illuminate\Support\Facades\Route;

Route::prefix('/user')->middleware(['auth', 'role:customer'])->as('user.')->group(function () {
    Route::resource('/course', UserCourseController::class)->except(['destroy', 'create', 'edit', 'update']);
});
