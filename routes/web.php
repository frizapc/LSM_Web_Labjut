<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages/dashboard');
});

Route::resource('courses', CourseController::class);
Route::resource('courses.materials', MaterialController::class);
Route::resource('courses.exams', ExamController::class);
Route::resource('courses.exams.questions', QuestionController::class);