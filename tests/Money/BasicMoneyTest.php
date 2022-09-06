<?php

namespace Cyrtolat\Money\Tests\Money;

use Cyrtolat\Money\Money;

class BasicMoneyTest extends MoneyTest
{
    /** @test */
    public function test_getAmount_method()
    {
        $money = new Money(150, 'RUB');

        $this->assertSame(150, $money->getAmount());
        $this->assertNotSame(1.50, $money->getAmount());
    }

    /** @test */
    public function test_getCurrency_method()
    {
        $money = new Money(150, 'RUB');

        $this->assertSame('RUB', $money->getCurrency());
    }

    /** @test */
    public function test_hasSameAmount_method()
    {
        $money = new Money(150, 'RUB');

        $this->assertTrue($money->hasSameAmount(
            new Money(150, 'RUB')
        ));

        $this->assertFalse($money->hasSameAmount(
            new Money(1.50, 'RUB')
        ));
    }

    /** @test */
    public function test_hasSameCurrency_method()
    {
        $money = new Money(150, 'RUB');

        $this->assertTrue($money->hasSameCurrency(
            new Money(150, 'RUB')
        ));

        $this->assertFalse($money->hasSameCurrency(
            new Money(150, 'USD')
        ));
    }
}