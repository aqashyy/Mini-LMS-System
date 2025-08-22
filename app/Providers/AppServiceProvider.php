<?php

namespace App\Providers;

use App\Interfaces\Admin\CourseRepoInterface;
use App\Interfaces\AuthServiceInterface;
use App\Repositories\CourseRepo;
use App\Services\Auth\AuthService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(CourseRepoInterface::class, CourseRepo::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
