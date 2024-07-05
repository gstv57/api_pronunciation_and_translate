<?php

namespace App\Providers;

use App\Contracts\TranslatorContract;
use App\Services\TranslatorService;
use Illuminate\Support\ServiceProvider;

class TranslatorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TranslatorContract::class, TranslatorService::class);
    }
    public function boot(): void
    {
        //
    }
}
