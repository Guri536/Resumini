<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ResAI;

class ResAIGem extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ResAI::class, function($app){
            return new ResAI();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
