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
use App\Enums\VirtualMedia\VirtualMediaTypeEnum;
use App\FFMpeg\Factories\Filters\FFMpegATrimFilterFactory;
use App\FFMpeg\Factories\Filters\FFMpegOverlayFilterFactory;
use App\FFMpeg\Factories\Filters\FFMpegScaleFilterFactory;
use App\FFMpeg\Factories\Filters\FFMpegTrimFilterFactory;
use App\Repositories\MediaRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Repositories\VirtualMediaRepository;
use App\Services\MediaService;
use App\Services\ProjectService;
use App\Services\UserService;
use App\Services\VirtualMediaService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $videoStreamFilterFactories = [FFMpegTrimFilterFactory::class];
        $videoFilterFactories = [FFMpegOverlayFilterFactory::class, FFMpegScaleFilterFactory::class,];
        $audioFilterFactories = [FFMpegATrimFilterFactory::class];


        $this->app->tag([...$videoFilterFactories, ...$audioFilterFactories, ...$videoStreamFilterFactories], 'videoFilterFactories');
        $this->app->tag([...$audioFilterFactories], 'audioFilterFactories');
        $this->app->tag([...$videoFilterFactories], VirtualMediaTypeEnum::Image->getTag());

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
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
