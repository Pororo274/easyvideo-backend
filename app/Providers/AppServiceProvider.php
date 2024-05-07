<?php

namespace App\Providers;

use App\Contracts\Repositories\ProjectRepositoryContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\ProjectServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Services\ProjectService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
        $this->app->bind(UserServiceContract::class, UserService::class);

        $this->app->bind(ProjectRepositoryContract::class, ProjectRepository::class);
        $this->app->bind(ProjectServiceContract::class, ProjectService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
