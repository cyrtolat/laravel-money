<?php

namespace Cyrtolat\Money;

use Cyrtolat\Money\Contracts\CurrencyStorage;
use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Formatters\DefaultFormatter;
use Cyrtolat\Money\Storages\DefaultStorage;
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
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'money');

        $this->app->singleton(CurrencyStorage::class, function () {
            return new DefaultStorage();
        });

        $this->app->bind(MoneyFormatter::class, function () {
            return new DefaultFormatter();
        });

        $this->app->bind('money', function ($app) {
            return new MoneyService(
                $app->make(CurrencyStorage::class),
                $app->make(MoneyFormatter::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([__DIR__.'/../config/config.php' => config_path('money.php')]);
    }
}
