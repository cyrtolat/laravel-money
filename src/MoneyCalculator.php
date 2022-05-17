<?php

namespace Cyrtolat\Money;

use Cyrtolat\Money\Exceptions\CalculatorException;

/**
 * The Money calculator class.
 */
final class MoneyCalculator
{
    /**
     * Returns a new Money instance that represents
     * the sum of given Money instance and an addend values.
     *
     * @param Money $summand   The summand Money instance.
     * @param Money[] $addends Addends Money instances.
     * @return Money
     */
    public static function getAdditionOf(Money $summand, array $addends): Money
    {
        $currency = $summand->getCurrency();
        $amount = $summand->getMinorAmount();

        foreach ($addends as $addend)
        {
            if ($currency->notEqualTo($addend->getCurrency()))
            {
                throw new CalculatorException('Currency of addend monies must be identical to summand.');
            }

            $amount += $addend->getMinorAmount();
        }

        return new Money($amount, $currency);
    }

    /**
     * Returns a new Money instance that represents the difference
     * of given Money and a subtrahends Money instances.
     *
     * @param Money $minuend       The minuend Money instance.
     * @param Money[] $subtrahends Subtrahends monies or their minor values.
     * @return Money
     */
    public static function getSubtractionOf(Money $minuend, array $subtrahends): Money
    {
        $currency = $minuend->getCurrency();
        $amount = $minuend->getMinorAmount();

        foreach ($subtrahends as $subtrahend)
        {
            if ($currency->notEqualTo($subtrahend->getCurrency()))
            {
                throw new CalculatorException('Currencies of subtrahend monies must be identical to minuend.');
            }

            $amount -= $subtrahend->getMinorAmount();
        }

        return new Money($amount, $currency);
    }

    /**
     * Returns a new Money instance that represents
     * the product of given Money instance by the given factor.
     *
     * @param Money $multiplicand The multiplicand.
     * @param mixed $multiplier   The multiplier.
     * @param int $roundingMode   An optional RoundingMode constant.
     * @return Money
     */
    public static function getMultiplicationOf(Money $multiplicand, mixed $multiplier, int $roundingMode): Money
    {
        if (! is_numeric($multiplier))
        {
            throw new CalculatorException('The multiplier must be a number.');
        }

        $amount = $multiplicand->getMinorAmount() * $multiplier;
        $currency = $multiplicand->getCurrency();

        return new Money(round($amount, 0, $roundingMode), $currency);
    }

    /**
     * Returns a new Money instance that represents
     * the quotient of given Money instance by the given factor.
     *
     * @param Money $dividend   The multiplicand.
     * @param mixed $divisor    The divisor.
     * @param int $roundingMode An optional RoundingMode constant.
     * @return Money
     */
    public static function getDivisionOf(Money $dividend, mixed $divisor, int $roundingMode): Money
    {
        if (! is_numeric($divisor))
        {
            throw new CalculatorException('The divisor must be a number.');
        }

        $amount = $dividend->getMinorAmount() / $divisor;
        $currency = $dividend->getCurrency();

        return new Money(round($amount, 0, $roundingMode), $currency);
    }
}
