<?php

namespace App\Providers;

use App\Models\CourseContent;
use Illuminate\Support\ServiceProvider;
use App\Observers\CourseContentObserver;

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
        CourseContent::observe(CourseContentObserver::class);
    }
}
