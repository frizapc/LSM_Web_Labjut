<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages/dashboard');
});

Route::resources([
    'courses' => CourseController::class,
]);