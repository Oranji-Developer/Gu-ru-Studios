<?php

use App\Http\Controllers\Customer\TransactionController;
use App\Http\Controllers\Customer\UserCourseController;
use Illuminate\Support\Facades\Route;

Route::prefix('/user')->middleware(['auth', 'role:customer'])->as('user.')->group(function () {
    Route::resource('/course', UserCourseController::class)->except(['destroy', 'create', 'edit', 'update']);

    Route::get('/invoice/{course_id}/{children_id}', [TransactionController::class, 'invoice'])->name('invoice');
    Route::get('/payment/{id}/whatshapp', [TransactionController::class, 'paymentWhatshapp'])->name('payment.whatshapp');
});
