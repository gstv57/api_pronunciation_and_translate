<?php

namespace App\Providers;

use App\Contracts\FetchWordRandomContract;
use App\Services\FetchWordRandomService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FetchWordRandomContract::class, FetchWordRandomService::class);
    }
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
