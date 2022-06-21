<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\Exceptions\MoneyCalculatorException;
use Cyrtolat\Money\MoneyCalculator;
use Cyrtolat\Money\Money;

class MoneyCalculatorExceptionsTest extends TestCase
{
    /**
     * Testing the exception when currencies differ.
     *
     * @return void
     * @test
     */
    public function testAdditionsDifferentCurrenciesException()
    {
        $this->expectException(MoneyCalculatorException::class);

        $rub = Money::of(500, "RUB");
        $usd = Money::of(500, "USD");

        MoneyCalculator::getAdditionOf($rub, [$usd]);
    }

    /**
     * Testing the exception when currencies differ.
     *
     * @return void
     * @test
     */
    public function testSubtractionDifferentCurrenciesException()
    {
        $this->expectException(MoneyCalculatorException::class);

        $rub = Money::of(500, "RUB");
        $usd = Money::of(500, "USD");

        MoneyCalculator::getSubtractionOf($rub, [$usd]);
    }
}