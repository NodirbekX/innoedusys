<?php

namespace App\Providers;

use App\Models\TeacherAssignment;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        // Explicit route model binding for assignment parameter
        Route::bind('assignment', function ($value) {
            return TeacherAssignment::findOrFail($value);
        });
    }
}
