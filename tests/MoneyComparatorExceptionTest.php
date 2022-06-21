<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Exceptions\MoneyComparatorException;
use Cyrtolat\Money\Exceptions\CurrencyProviderException;
use Cyrtolat\Money\Money;
use Cyrtolat\Money\MoneyComparator;

class MoneyComparatorExceptionTest extends TestCase
{
    /**
     * Testing the exception when currencies differ.
     *
     * @return void
     * @test
     */
    public function testAlphabeticCodeDoesntExist()
    {
        $this->expectException(MoneyComparatorException::class);

        $rub = Money::of(500, "RUB");
        $usd = Money::of(500, "USD");

        MoneyComparator::compare($rub, $usd);
    }
}