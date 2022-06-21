<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Money;

class MoneyDomainTest extends TestCase
{
    /**
     * Testing a basement of Money class.
     *
     * @return void
     * @test
     */
    public function testBasement()
    {
        $minorAmount = 15423;
        $majorAmount = 154.23;
        $currency = Currency::of("RUB");
        $money = new Money($minorAmount, $currency);

        $this->assertTrue($money->getMinorAmount() === $minorAmount);
        $this->assertTrue($money->getMajorAmount() === $majorAmount);
        $this->assertTrue($money->getCurrency() === $currency);
    }

    /**
     * Testing a Money comparing methods.
     *
     * @return void
     * @test
     */
    public function testComparing()
    {
        $rub = new Money(15600, Currency::of("RUB"));
        $usd = new Money(15600, Currency::of("USD"));

        $this->assertTrue($rub->hasSameCurrency($rub));
        $this->assertFalse($rub->hasSameCurrency($usd));

        $positive = new Money(100, Currency::of("RUB"));
        $negative = new Money(-100, Currency::of("RUB"));
        $zero = new Money(0, Currency::of("RUB"));

        $this->assertTrue($positive->isPositive());
        $this->assertTrue($negative->isNegative());
        $this->assertTrue($zero->isZero());

        $monies_1 = new Money(15000, Currency::of("RUB"));
        $monies_2 = new Money(15000, Currency::of("RUB"));
        $monies_3 = new Money(15023, Currency::of("RUB"));
        $monies_4 = new Money(15600, Currency::of("RUB"));

        $this->assertTrue($monies_1->equals($monies_2));
        $this->assertFalse($monies_1->equals($monies_3));

        $this->assertTrue($monies_1->lt($monies_3));
        $this->assertFalse($monies_3->lt($monies_1));

        $this->assertTrue($monies_1->lte($monies_3));
        $this->assertFalse($monies_3->lte($monies_1));

        $this->assertTrue($monies_1->lte($monies_1));

        $this->assertTrue($monies_4->gt($monies_3));
        $this->assertFalse($monies_3->gt($monies_4));

        $this->assertTrue($monies_4->gte($monies_3));
        $this->assertFalse($monies_3->gte($monies_4));

        $this->assertTrue($monies_4->gte($monies_4));
    }

    /**
     * Testing a Money factory methods.
     *
     * @return void
     * @test
     */
    public function testFactory()
    {
        $minorAmount = 15423;
        $majorAmount = 154.23;
        $currency = Currency::of("RUB");

        $rub_1 = new Money($minorAmount, $currency);
        $rub_2 = Money::ofMinor($minorAmount, $currency);
        $rub_3 = Money::of($majorAmount, $currency);

        $this->assertTrue($rub_1->equals($rub_2));
        $this->assertTrue($rub_1->equals($rub_3));
    }

    /**
     * Testing a Money rounding methods.
     *
     * @return void
     * @test
     */
    public function testRounding()
    {
        $rub_154_23 = Money::of(154.23, "RUB");
        $rub_154_20 = Money::of(154.20, "RUB");
        $rub_154_00 = Money::of(154.00, "RUB");
        $rub_150_00 = Money::of(150.00, "RUB");
        $rub_200_00 = Money::of(200.00, "RUB");

        $this->assertTrue($rub_154_23->round(-2)->equals($rub_200_00));
        $this->assertTrue($rub_154_23->round(-1)->equals($rub_150_00));
        $this->assertTrue($rub_154_23->round(0)->equals($rub_154_00));
        $this->assertTrue($rub_154_23->round(1)->equals($rub_154_20));
        $this->assertTrue($rub_154_23->round(2)->equals($rub_154_23));
    }

    /**
     * Testing a Money comparing methods.
     *
     * @return void
     * @test
     */
    public function testCalculations()
    {
        $this->assertTrue(
            Money::of(15.00, "RUB")->plus(
            Money::of(15.01, "RUB"),
            Money::of(15.02, "RUB"),
            Money::of(15.03, "RUB")
        )->equals(
            Money::of(60.06, "RUB")
        ));

        $this->assertTrue(
            Money::of(60.00, "RUB")->minus(
            Money::of(15.01, "RUB"),
            Money::of(15.02, "RUB"),
            Money::of(15.03, "RUB")
        )->equals(
            Money::of(14.94, "RUB")
        ));

        $this->assertTrue(
            Money::of(60.00, "RUB")->multiplyBy(3)->equals(
            Money::of(180.0, "RUB")
        ));

        $this->assertTrue(
            Money::of(60.00, "RUB")->divideBy(3)->equals(
            Money::of(20.0, "RUB")
        ));
    }
}
