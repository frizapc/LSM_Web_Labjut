<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use function Pest\Laravel\withoutMiddleware;


Route::controller(AuthController::class)
->middleware('guest')
    ->group(function () {
        Route::get('/login', 'login')
        ->name('login');
        Route::post('/login', 'authenticate')
        ->name('authenticate');
        Route::get('/register', 'register')
        ->name('register');
        Route::post('/register', 'store')
        ->name('store.user');
        Route::get('/logout', 'logout')
        ->name('logout')
        ->withoutMiddleware('guest')
        ->middleware('auth');
    });
    
Route::middleware('auth')
    ->group(function() {
        Route::get('/', function () {
            return view('pages/dashboard');
        });

        Route::singleton('profile', ProfileController::class);

        Route::resource('courses', CourseController::class);
        
        Route::resource('courses.materials', MaterialController::class)
            ->except(['index', 'show']);

        Route::post('/courses/{courseId}/exams/{examId}',[ExamController::class, 'submit'])
            ->name('courses.exams.submit');
        Route::resource('courses.exams', ExamController::class)
            ->except(['index']);

        Route::resource('courses.exams.questions', QuestionController::class)
            ->except(['index', 'create', 'show', 'edit']);

});



