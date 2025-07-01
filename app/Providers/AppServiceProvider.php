<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Material;
use App\Models\Question;
use App\Models\User;
use App\Observers\CourseObserver;
use App\Observers\MaterialObserver;
use App\Observers\ProfileObserver;
use App\Observers\QuestionObserver;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        User::observe(ProfileObserver::class);
        Course::observe(CourseObserver::class);
        Material::observe(MaterialObserver::class);
        Question::observe(QuestionObserver::class);
        Carbon::setLocale('id');
    }
}
