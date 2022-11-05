<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\Money;
use InvalidArgumentException;

class MoneyTest extends TestCase
{
    /** @test */
    public function getAmount_method()
    {
        $money = new Money(150, 'RUB');

        $this->assertSame(150, $money->amount);
        $this->assertNotSame(1.50, $money->amount);
    }

    /** @test */
    public function getCurrency_method()
    {
        $money = new Money(150, 'RUB');

        $this->assertSame('RUB', $money->currency);
    }

    /** @test */
    public function equals_method()
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
    public function equals_method_exception()
    {
        $money = new Money(150, 'RUB');

        $this->expectException(InvalidArgumentException::class);

        $money->equals(new Money(150, 'USD'));
    }

    /** @test */
    public function gt_method()
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
    public function gt_method_exception()
    {
        $money = new Money(150, 'RUB');

        $this->expectException(InvalidArgumentException::class);

        $money->gt(new Money(150, 'USD'));
    }

    /** @test */
    public function gte_method()
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
    public function gte_method_exception()
    {
        $money = new Money(150, 'RUB');

        $this->expectException(InvalidArgumentException::class);

        $money->gte(new Money(150, 'USD'));
    }

    /** @test */
    public function lt_method()
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
    public function lt_method_exception()
    {
        $money = new Money(150, 'RUB');

        $this->expectException(InvalidArgumentException::class);

        $money->lt(new Money(150, 'USD'));
    }

    /** @test */
    public function lte_method()
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
    public function lte_method_exception()
    {
        $money = new Money(150, 'RUB');

        $this->expectException(InvalidArgumentException::class);

        $money->lte(new Money(150, 'USD'));
    }

    /** @test */
    public function plus_method()
    {
        $money = new Money(150, 'RUB');
        $other = new Money(50, 'RUB');
        $expect = new Money(200, 'RUB');

        $result = $money->plus($other);

        $this->assertTrue($expect->equals($result));
    }

    /** @test */
    public function plus_method_exception()
    {
        $money = new Money(150, 'RUB');
        $other = new Money(50, 'USD');

        $this->expectException(InvalidArgumentException::class);

        $money->plus($other);
    }

    /** @test */
    public function minus_method()
    {
        $money = new Money(150, 'RUB');
        $other = new Money(50, 'RUB');
        $expect = new Money(100, 'RUB');

        $result = $money->minus($other);

        $this->assertTrue($expect->equals($result));
    }

    /** @test */
    public function minus_method_exception()
    {
        $money = new Money(150, 'RUB');
        $other = new Money(50, 'USD');

        $this->expectException(InvalidArgumentException::class);

        $money->minus($other);
    }

    /** @test */
    public function multiplyBy_method()
    {
        $money = new Money(100, 'RUB');

        $result = $money->multiplyBy(2.335, PHP_ROUND_HALF_UP);
        $this->assertEquals(234, $result->amount);

        $result = $money->multiplyBy(2.335, PHP_ROUND_HALF_DOWN);
        $this->assertEquals(233, $result->amount);

        $result = $money->multiplyBy(2.335, PHP_ROUND_HALF_EVEN);
        $this->assertEquals(234, $result->amount);

        $result = $money->multiplyBy(2.335, PHP_ROUND_HALF_ODD);
        $this->assertEquals(233, $result->amount);
    }

    /** @test */
    public function divideBy_method()
    {
        $money = new Money(100, 'RUB');

        $result = $money->divideBy(1.6, PHP_ROUND_HALF_UP);
        $this->assertEquals(63, $result->amount);

        $result = $money->divideBy(1.6, PHP_ROUND_HALF_DOWN);
        $this->assertEquals(62, $result->amount);

        $result = $money->divideBy(1.6, PHP_ROUND_HALF_EVEN);
        $this->assertEquals(62, $result->amount);

        $result = $money->divideBy(1.6, PHP_ROUND_HALF_ODD);
        $this->assertEquals(63, $result->amount);
    }

    /** @test */
    public function round_method()
    {
        $money = new Money(1111, 'RUB');

        $result = $money->round(0, PHP_ROUND_HALF_UP);
        $this->assertEquals(1111, $result->amount);

        $result = $money->round(1, PHP_ROUND_HALF_UP);
        $this->assertEquals(1110, $result->amount);

        $result = $money->round(2, PHP_ROUND_HALF_UP);
        $this->assertEquals(1100, $result->amount);
    }
}