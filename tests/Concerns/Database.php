<?php

namespace Cyrtolat\Money\Tests\Concerns;

trait Database
{
    protected function setDatabase($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.' . 'testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function freshDatabase(): void
    {
        $this->refreshDatabase();
        $this->loadMigrations();

        $this->artisan('migrate')->run();
    }

    protected function loadMigrations(): void
    {
        $this->loadMigrationsFrom(
            __DIR__ . '/../Migrations');
    }
}