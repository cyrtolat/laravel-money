<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Exceptions\CurrencyException;
use Cyrtolat\Money\Providers\MoneyCurrencyProvider;

class CurrencyExceptionTest extends TestCase
{
    /**
     * Testing the exception when alphabetic doesn't exist.
     *
     * @return void
     * @test
     */
    public function testAlphabeticCodeDoesntExist()
    {
        $this->expectException(CurrencyException::class);

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
        $this->expectException(CurrencyException::class);

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
    public function testNumericCodeAlreadyExists()
    {
        $this->expectException(CurrencyException::class);

        $provider = MoneyCurrencyProvider::getInstance();
        $currency = new Currency(
            "MCC",
            "My custom currency",
            "643",
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
        $this->expectException(CurrencyException::class);

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