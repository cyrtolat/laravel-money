<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\Money;
use Cyrtolat\Money\MoneyComparator;
use Cyrtolat\Money\Exceptions\MoneyComparatorException;

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

    /**
     * Testing the retrieved comparing value.
     *
     * @return void
     * @test
     * @throws MoneyComparatorException
     */
    public function testRetrievedValue()
    {
        $rub_50 = Money::of(50, 'RUB');
        $rub_75 = Money::of(75, 'RUB');

        $this->assertTrue(MoneyComparator::compare($rub_50, $rub_75) === -1);
        $this->assertTrue(MoneyComparator::compare($rub_75, $rub_50) === 1);
        $this->assertTrue(MoneyComparator::compare($rub_50, $rub_50) === 0);
    }
}