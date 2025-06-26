<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\MaterialController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages/dashboard');
});

Route::resource('courses', CourseController::class);
Route::resource('courses.materials', MaterialController::class);