<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Exceptions\CurrencyException;
use Cyrtolat\Money\Providers\MoneyCurrencyProvider;

class CurrencyDomainTest extends TestCase
{
    /**
     * Testing a basement of Currency class.
     *
     * @return void
     * @test
     */
    public function testBasement()
    {
        $alphabeticCode = "RUB";
        $currencyName = "Russian Ruble";
        $numericCode = "643";
        $fractionDigits = 2;

        $rub = new Currency($alphabeticCode, $currencyName, $numericCode, $fractionDigits);

        $this->assertTrue($rub->getAlphabeticCode() === $alphabeticCode);
        $this->assertTrue($rub->getCurrencyName() === $currencyName);
        $this->assertTrue($rub->getNumericCode() === $numericCode);
        $this->assertTrue($rub->getFractionDigits() === $fractionDigits);
    }

    /**
     * Testing a Currency comparing methods.
     *
     * @return void
     * @test
     */
    public function testComparing()
    {
        $rub = new Currency("RUB", "Russian Ruble", "643", 2);
        $usd = new Currency("USD", "US Dollar", "840", 2);

        $this->assertTrue($rub->equals($rub));
        $this->assertFalse($rub->equals($usd));
    }

    /**
     * Testing a Currency factory methods.
     *
     * @return void
     * @test
     */
    public function testFactory()
    {
        $first = new Currency("RUB", "Russian Ruble", "643", 2);
        $second = Currency::of("RUB");

        $this->assertTrue($first->equals($second));
    }

    /**
     * Testing a Currency provider.
     *
     * @return void
     * @test
     */
    public function testProviding()
    {
        $provider = MoneyCurrencyProvider::getInstance();

        $rub = new Currency("RUB", "Russian Ruble", "643", 2);

        $this->assertTrue($rub->equals($provider->getCurrency("RUB")));
    }

    /**
     * Testing a registration of custom Currency.
     *
     * @return void
     * @test
     */
    public function testRegistration()
    {
        $provider = MoneyCurrencyProvider::getInstance();

        $mcc = new Currency("MCC", "My Custom Currency", "0", 4);

        $provider->registerCurrency($mcc);

        $this->assertTrue($mcc->equals($provider->getCurrency("MCC")));
    }
}
