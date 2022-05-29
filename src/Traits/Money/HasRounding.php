<?php

namespace Cyrtolat\Money\Traits\Money;

use Cyrtolat\Money\Money;

/**
 * The Money rounding trait.
 */
trait HasRounding
{
    /**
     * Returns a new instance of the Money class, the amount
     * of which is rounded amount of this instance.
     *
     * @param integer $precision The optional number of decimal digits to round to.
     * @param integer $mode One of PHP_ROUND_HALF_UP, PHP_ROUND_HALF_DOWN, PHP_ROUND_HALF_EVEN, or PHP_ROUND_HALF_ODD.
     * @return Money
     */
    public function round(int $precision = 0, $mode = PHP_ROUND_HALF_UP): Money
    {
        return Money::of(round($this->getMajorAmount(), $precision, $mode), $this->getCurrency());
    }
}
