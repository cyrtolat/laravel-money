<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\MoneyServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [MoneyServiceProvider::class];
    }
}