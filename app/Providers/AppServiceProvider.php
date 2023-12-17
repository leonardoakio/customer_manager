<?php

namespace App\Providers;

use App\Infrastructure\Adapters\CacheInterface;
use App\Infrastructure\Adapters\RedisCacheLaravelAdapter;
use App\Infrastructure\Repositories\CustomerRepositoryInterface;
use App\Infrastructure\Repositories\CustomerRepository;

use App\Infrastructure\Repositories\PostalCodeRepository;
use App\Infrastructure\Repositories\PostalCodeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(PostalCodeRepositoryInterface::class, PostalCodeRepository::class);
        // $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);

        $this->app->bind(CacheInterface::class, RedisCacheLaravelAdapter::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
