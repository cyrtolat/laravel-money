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

    /**
     * Testing the exception when alphabetic already exists.
     *
     * @return void
     * @test
     */
    public function testAlphabeticCodeAlreadyExists()
    {
        $this->expectException(CurrencyProviderException::class);

        $provider = MoneyCurrencyProvider::getInstance();
        $currency = new Currency(
            "RUB",
            "My custom currency",
            "0",
            2
        );

        $provider->registerCurrency($currency);
    }

    /**
     * Testing the exception when alphabetic already exists.
     *
     * @return void
     * @test
     */
    public function testCurrencyAlreadyRegistered()
    {
        $this->expectException(CurrencyProviderException::class);

        $provider = MoneyCurrencyProvider::getInstance();
        $currency = new Currency(
            "MCC",
            "My custom currency new",
            "0",
            2
        );

        $provider->registerCurrency($currency);
    }
}