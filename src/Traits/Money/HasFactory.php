<?php

namespace Cyrtolat\Money\Traits\Money;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Money;

/**
 * Money Factory trait.
 */
trait HasFactory
{
    /**
     * Returns new Money instance by the given a minor amount and currency.
     *
     * @param integer $amount The money amount in minor value.
     * @param mixed $currency The Currency instance or 3-letter uppercase code.
     * @return Money
     */
    public static function ofMinor(int $amount, mixed $currency): Money
    {
        if ($currency instanceof Currency) {
            return new Money($amount, $currency);
        }

        if (is_string($currency)) {
            return new Money($amount, Currency::of($currency));
        }

        throw new \InvalidArgumentException("The given Currency must be an instance of Currency class or 3-letter uppercase code");
    }

    /**
     * Returns new Money instance by the given a major amount and currency.
     *
     * @param mixed $amount The money amount in a major integer or decimal value.
     * @param mixed $currency The Currency instance or 3-letter uppercase code.
     * @param integer $roundingMode An optional RoundingMode constant.
     * @return Money
     */
    public static function ofMajor(mixed $amount, mixed $currency, int $roundingMode = PHP_ROUND_HALF_EVEN): Money
    {
        if (! is_numeric($amount)) {
            throw new \InvalidArgumentException("The given amount must be a numeric value.");
        }

        if ($currency instanceof Currency) {
            $subunit = pow(10, $currency->getFractionDigits());
            $amount = round($amount * $subunit, 0, $roundingMode);
            return new Money($amount, $currency);
        }

        if (is_string($currency)) {
            $currency = Currency::of($currency);
            $subunit = pow(10, $currency->getFractionDigits());
            $amount = round($amount * $subunit, 0, $roundingMode);
            return new Money($amount, $currency);
        }

        throw new \InvalidArgumentException("The given Currency must be an instance of Currency class or 3-letter uppercase code");
    }
}
