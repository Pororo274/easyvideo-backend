<?php

namespace App\Providers;

use App\Contracts\Repositories\MediaRepositoryContract;
use App\Contracts\Repositories\ProjectRepositoryContract;
use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Repositories\VirtualMediaRepositoryContract;
use App\Contracts\Services\MediaServiceContract;
use App\Contracts\Services\ProjectServiceContract;
use App\Contracts\Services\UserServiceContract;
use App\Contracts\Services\VirtualMediaServiceContract;
use App\Repositories\MediaRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Repositories\VirtualMediaRepository;
use App\Services\MediaService;
use App\Services\ProjectService;
use App\Services\UserService;
use App\Services\VirtualMediaService;
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

        $this->app->bind(MediaRepositoryContract::class, MediaRepository::class);
        $this->app->bind(MediaServiceContract::class, MediaService::class);

        $this->app->bind(VirtualMediaRepositoryContract::class, VirtualMediaRepository::class);
        $this->app->bind(VirtualMediaServiceContract::class, VirtualMediaService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
