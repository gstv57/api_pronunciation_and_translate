<?php

namespace App\Providers;

use App\Contracts\PronunciationContract;
use App\Services\PronunciationService;
use Illuminate\Support\ServiceProvider;

class PronunciationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(PronunciationContract::class, PronunciationService::class);
    }

    public function boot(): void
    {
        //
    }
}
