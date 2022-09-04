<?php

namespace Cyrtolat\Money\Tests\Unit\Money;

use Cyrtolat\Money\Exceptions\MoneyException;
use Cyrtolat\Money\Money;

class MathMoneyTest extends MoneyTest
{
    /** @test */
    public function test_plus()
    {
        $money = new Money(150, 'RUB');
        $other = new Money(50, 'RUB');
        $expect = new Money(200, 'RUB');

        $result = $money->plus($other);

        $this->assertTrue($expect->equals($result));
    }

    /** @test */
    public function test_plus_exception()
    {
        $money = new Money(150, 'RUB');
        $other = new Money(50, 'USD');

        $this->expectException(MoneyException::class);

        $money->plus($other);
    }

    /** @test */
    public function test_minus()
    {
        $money = new Money(150, 'RUB');
        $other = new Money(50, 'RUB');
        $expect = new Money(100, 'RUB');

        $result = $money->minus($other);

        $this->assertTrue($expect->equals($result));
    }

    /** @test */
    public function test_minus_exception()
    {
        $money = new Money(150, 'RUB');
        $other = new Money(50, 'USD');

        $this->expectException(MoneyException::class);

        $money->minus($other);
    }

    /** @test */
    public function test_multiplyBy()
    {
        $money = new Money(100, 'RUB');

        $result = $money->multiplyBy(2.335, PHP_ROUND_HALF_UP);
        $this->assertEquals($result->getAmount(), 234);

        $result = $money->multiplyBy(2.335, PHP_ROUND_HALF_DOWN);
        $this->assertEquals($result->getAmount(), 233);

        $result = $money->multiplyBy(2.335, PHP_ROUND_HALF_EVEN);
        $this->assertEquals($result->getAmount(), 234);

        $result = $money->multiplyBy(2.335, PHP_ROUND_HALF_ODD);
        $this->assertEquals($result->getAmount(), 233);
    }

    /** @test */
    public function test_divideBy()
    {
        $money = new Money(100, 'RUB');

        $result = $money->divideBy(1.6, PHP_ROUND_HALF_UP);
        $this->assertEquals($result->getAmount(), 63);

        $result = $money->divideBy(1.6, PHP_ROUND_HALF_DOWN);
        $this->assertEquals($result->getAmount(), 62);

        $result = $money->divideBy(1.6, PHP_ROUND_HALF_EVEN);
        $this->assertEquals($result->getAmount(), 62);

        $result = $money->divideBy(1.6, PHP_ROUND_HALF_ODD);
        $this->assertEquals($result->getAmount(), 63);
    }

    /** @test */
    public function test_round_method()
    {
        $money = new Money(1111, 'RUB');

        $result = $money->round(0, PHP_ROUND_HALF_UP);
        $this->assertEquals($result->getAmount(), 1111);

        $result = $money->round(1, PHP_ROUND_HALF_UP);
        $this->assertEquals($result->getAmount(), 1110);

        $result = $money->round(2, PHP_ROUND_HALF_UP);
        $this->assertEquals($result->getAmount(), 1100);
    }
}