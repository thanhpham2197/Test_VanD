<?php

namespace App\Providers;

use App\Repository\Interface\ProductRepositoryInterface;
use App\Repository\Interface\StoreRepositoryInterface;
use App\Repository\Interface\UserRepositoryInterface;
use App\Repository\ProductRepository;
use App\Repository\StoreRepository;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(StoreRepositoryInterface::class, StoreRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }
}
