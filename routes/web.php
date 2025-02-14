<?php

use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\GlobalController;
use App\Models\Course;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});
