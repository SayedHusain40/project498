<?php

namespace App\Providers;

use App\Models\College;
use App\Models\Department;


use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use App\Listeners\LogLogin;

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
        view()->share('colleges', $colleges);

        Event::listen(
            Login::class,
            [LogLogin::class, 'handle']
        );
    }
}
