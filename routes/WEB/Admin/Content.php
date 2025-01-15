<?php

use App\Http\Controllers\Admin\ContentController;
use Illuminate\Support\Facades\Route;

Route::prefix('/admin')->middleware(['auth', 'role:admin'])->as('admin.')->group(function () {
    Route::resource('/content', ContentController::class)->except(['show']);
});
