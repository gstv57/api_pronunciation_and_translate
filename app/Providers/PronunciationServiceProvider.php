<?php

namespace App\Providers;

use App\Services\PronunciationService;
use Illuminate\Support\ServiceProvider;
use App\Contracts\PronunciationContract;

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
