<?php

namespace Cyrtolat\Money\Providers;

use Cyrtolat\Money\Services\MoneyService;
use Illuminate\Support\ServiceProvider;

class MoneyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '../../config/config.php', 'money');

        $this->app->singleton(MoneyService::class, function () {
            return new MoneyService(config('money'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '../../config/config.php' => config_path('money.php')]);
    }
}
