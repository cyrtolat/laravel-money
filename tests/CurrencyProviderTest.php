<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Exceptions\CurrencyProviderException;
use Cyrtolat\Money\Providers\MoneyCurrencyProvider;

class CurrencyProviderTest extends TestCase
{
    /**
     * Testing the exception when alphabetic doesn't exist.
     *
     * @return void
     * @test
     */
    public function testAlphabeticCodeDoesntExist()
    {
        $this->expectException(CurrencyProviderException::class);

        $currency = Currency::of("UNK");
    }
}