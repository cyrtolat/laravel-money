<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\Providers\MoneyServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cyrtolat\Money\Tests\Concerns\Database;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use Database, RefreshDatabase;

    protected function getPackageProviders($app)
    {
        return [MoneyServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $this->setDatabase($app);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->freshDatabase();
    }
}