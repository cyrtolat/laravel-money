<?php

namespace Cyrtolat\Money\Traits\Money;

use Cyrtolat\Money\Money;
use Cyrtolat\Money\MoneyCalculator;
use Cyrtolat\Money\Exceptions\MoneyCalculatorException;

/**
 * The Money calculating trait.
 */
trait HasCalculations
{
    /**
     * Returns a new Money instance that represents
     * the sum of this instance and an addend Money instances.
     *
     * @param Money ...$addends Addends monies.
     * @return Money
     * @throws MoneyCalculatorException
     */
    public function plus(Money ...$addends): Money
    {
        return MoneyCalculator::getAdditionOf($this, $addends);
    }

    /**
     * Returns a new Money instance that represents the difference
     * of this instance and a subtrahends Money instances.
     *
     * @param Money ...$subtrahends Subtrahends monies.
     * @return Money
     * @throws MoneyCalculatorException
     */
    public function minus(Money ...$subtrahends): Money
    {
        return MoneyCalculator::getSubtractionOf($this, $subtrahends);
    }

    /**
     * Returns a new Money instance that represents the
     * product of this instance by the given factor.
     *
     * @param mixed   $multiplier   The multiplier.
     * @param integer $roundingMode An optional RoundingMode constant.
     * @return Money
     */
    public function multiplyBy($multiplier, int $roundingMode = PHP_ROUND_HALF_EVEN): Money
    {
        return MoneyCalculator::getMultiplicationOf($this, $multiplier, $roundingMode);
    }

    /**
     * Returns a new Money instance that represents the
     * quotient of this instance by the given factor.
     *
     * @param mixed   $divisor      The divisor.
     * @param integer $roundingMode An optional RoundingMode constant.
     * @return Money
     */
    public function divideBy($divisor, int $roundingMode = PHP_ROUND_HALF_EVEN): Money
    {
        return MoneyCalculator::getDivisionOf($this, $divisor, $roundingMode);
    }
}
