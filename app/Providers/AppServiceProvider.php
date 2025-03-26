<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ResAI;
use App\Helper\ResAIHelper;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ResAI::class, function($app){
            return new ResAI();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
