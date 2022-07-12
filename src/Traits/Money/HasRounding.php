<?php

namespace Cyrtolat\Money\Traits\Money;

use Cyrtolat\Money\Exceptions\CurrencyProviderException;
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
     * @throws CurrencyProviderException
     */
    public function round(int $precision = 0, int $mode = PHP_ROUND_HALF_UP): Money
    {
        return Money::of(round($this->getAmount(), $precision, $mode), $this->getCurrency());
    }
}
