<?php

namespace App\Providers;

use App\Models\College;
use App\Models\Department;


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
        //
        $colleges = College::with('departments.courses')->get();
        view()->share('colleges', $colleges);    }
}
