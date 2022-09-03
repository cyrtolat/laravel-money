<?php

namespace Cyrtolat\Money;

use Cyrtolat\Money\Contracts\CurrencyStorage;
use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Contracts\MoneySerializer;
use Cyrtolat\Money\Formatters\DefaultMoneyFormatter;
use Cyrtolat\Money\Serializers\MajorMoneySerializer;
use Cyrtolat\Money\Services\MoneyService;
use Cyrtolat\Money\Storages\DefaultMoneyStorage;
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

        $this->app->bind(CurrencyStorage::class, function () {
            return new DefaultMoneyStorage();
        });

        $this->app->bind(MoneyFormatter::class, function () {
            return new DefaultMoneyFormatter();
        });

        $this->app->bind(MoneySerializer::class, function () {
            return new MajorMoneySerializer();
        });

        $this->app->singleton(MoneyService::class, function ($app) {
            return new MoneyService(
                $app->make(CurrencyStorage::class),
                $app->make(MoneySerializer::class),
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
