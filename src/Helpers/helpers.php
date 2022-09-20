<?php

use Cyrtolat\Money\Money;
use Cyrtolat\Money\Currency;

if (! function_exists('money')) {
    /**
     * Returns new Money by the given values.
     *
     * @param float $amount A decimal sum in a major monetary style
     * @param mixed|null $currency Currency alphabetic or numeric code
     *                             or null to take default currency
     * @return Money New Money class instance
     */
    function money(float $amount, mixed $currency = null): Money
    {
        if (is_null($currency)) {
            $currency = config('money.currency');
        }

        return \Cyrtolat\Money\Facades\Money::of($amount, $currency);
    }
}

if (! function_exists('moneyOfMinor')) {
    /**
     * Returns new Money by the given values.
     *
     * @param int $amount An integer sum in minor monetary style
     * @param mixed|null $currency Currency alphabetic or numeric code
     *                             or null to take default currency
     * @return Money New Money class instance
     */
    function moneyOfMinor(int $amount, mixed $currency = null): Money
    {
        if (is_null($currency)) {
            $currency = config('money.currency');
        }

        return \Cyrtolat\Money\Facades\Money::ofMinor($amount, $currency);
    }
}

if (! function_exists('currency')) {
    /**
     * Returns new Currency by the given code or a default.
     *
     * @param string|null $code Alphabetic or numeric code or null to take default
     * @return Currency New Currency class instance
     */
    function currency(string $code = null): Currency
    {
        if (is_null($code)) {
            $code = config('money.currency');
        }

        return \Cyrtolat\Money\Facades\Money::getCurrencyOf($code);
    }
}

if (! function_exists('calcMajorAmount')) {
    /**
     * Return the major-style amount according to
     * the value of the minor Currency unit.
     *
     * @param integer $amount An integer minor-style amount
     * @param Currency $currency Currency instance with minor unit
     * @return float Major-style decimal amount
     */
    function calcMajorAmount(int $amount, Currency $currency): float
    {
        return $amount / pow(10, $currency->getMinorUnit());
    }
}

if (! function_exists('calcMinorAmount')) {
    /**
     * Return the minor-style amount according to
     * the value of the minor Currency unit.
     *
     * @param float $amount A float major-style rounded amount
     * @param Currency $currency Currency instance with minor unit
     * @param integer $roundingMode An optional RoundingMode constant
     * @return integer Minor-style integer amount
     */
    function calcMinorAmount(float $amount, Currency $currency, int $roundingMode = PHP_ROUND_HALF_UP): int
    {
        return round($amount * pow(10, $currency->getMinorUnit()), 0, $roundingMode);
    }
}
