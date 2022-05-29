<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\MoneyServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            MoneyServiceProvider::class,
        ];
    }
}