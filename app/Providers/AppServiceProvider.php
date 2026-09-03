<?php

namespace App\Providers;

use App\Repository\Contracts\CustomerRepoInterface;
use App\Repository\PengajuanRepository;
use App\Repository\Contracts\PengajuanRepoInterface;
use App\Repository\CustomerRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerRepoInterface::class, CustomerRepository::class);
        $this->app->bind(PengajuanRepoInterface::class, PengajuanRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
