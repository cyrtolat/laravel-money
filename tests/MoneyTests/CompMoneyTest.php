<?php

namespace Cyrtolat\Money\Tests\MoneyTests;

use Cyrtolat\Money\Exceptions\MoneyException;
use Cyrtolat\Money\Money;

class CompMoneyTest extends MoneyTest
{
    /** @test */
    public function test_equals_method()
    {
        $money = new Money(150, 'RUB');

        $this->assertTrue($money->equals(
            new Money(150, 'RUB')
        ));

        $this->assertFalse($money->equals(
            new Money(1.50, 'RUB')
        ));
    }

    /** @test */
    public function test_equals_method_exception()
    {
        $money = new Money(150, 'RUB');

        $this->expectException(MoneyException::class);

        $money->equals(new Money(150, 'USD'));
    }

    /** @test */
    public function test_gt_method()
    {
        $money = new Money(150, 'RUB');

        $this->assertTrue($money->gt(
            new Money(100, 'RUB')
        ));

        $this->assertFalse($money->gt(
            new Money(150, 'RUB')
        ));

        $this->assertFalse($money->gt(
            new Money(200, 'RUB')
        ));
    }

    /** @test */
    public function test_gt_method_exception()
    {
        $money = new Money(150, 'RUB');

        $this->expectException(MoneyException::class);

        $money->gt(new Money(150, 'USD'));
    }

    /** @test */
    public function test_gte_method()
    {
        $money = new Money(150, 'RUB');

        $this->assertTrue($money->gte(
            new Money(100, 'RUB')
        ));

        $this->assertTrue($money->gte(
            new Money(150, 'RUB')
        ));

        $this->assertFalse($money->gte(
            new Money(200, 'RUB')
        ));
    }

    /** @test */
    public function test_gte_method_exception()
    {
        $money = new Money(150, 'RUB');

        $this->expectException(MoneyException::class);

        $money->gte(new Money(150, 'USD'));
    }

    /** @test */
    public function test_lt_method()
    {
        $money = new Money(150, 'RUB');

        $this->assertTrue($money->lt(
            new Money(200, 'RUB')
        ));

        $this->assertFalse($money->lt(
            new Money(150, 'RUB')
        ));

        $this->assertFalse($money->lt(
            new Money(100, 'RUB')
        ));
    }

    /** @test */
    public function test_lt_method_exception()
    {
        $money = new Money(150, 'RUB');

        $this->expectException(MoneyException::class);

        $money->lt(new Money(150, 'USD'));
    }

    /** @test */
    public function test_lte_method()
    {
        $money = new Money(150, 'RUB');

        $this->assertTrue($money->lte(
            new Money(200, 'RUB')
        ));

        $this->assertTrue($money->lte(
            new Money(150, 'RUB')
        ));

        $this->assertFalse($money->lte(
            new Money(100, 'RUB')
        ));
    }

    /** @test */
    public function test_lte_method_exception()
    {
        $money = new Money(150, 'RUB');

        $this->expectException(MoneyException::class);

        $money->lte(new Money(150, 'USD'));
    }
}