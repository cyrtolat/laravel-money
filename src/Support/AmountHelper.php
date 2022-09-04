<?php

namespace Cyrtolat\Money\Support;

use Cyrtolat\Money\Currency;

final class AmountHelper
{
    /**
     * Return the major-style amount according to
     * the value of the minor Currency unit.
     *
     * @param integer $amount An integer minor-style amount
     * @param Currency $currency Currency instance with minor unit
     * @return float Major-style decimal amount
     */
    public static function calcMajorAmount(int $amount, Currency $currency): float
    {
        return $amount / pow(10, $currency->getMinorUnit());
    }

    /**
     * Return the minor-style amount according to
     * the value of the minor Currency unit.
     *
     * @param float $amount A float major-style rounded amount
     * @param Currency $currency Currency instance with minor unit
     * @param integer $roundingMode An optional RoundingMode constant
     * @return integer Minor-style integer amount
     */
    public static function calcMinorAmount(float $amount, Currency $currency, int $roundingMode = PHP_ROUND_HALF_UP): int
    {
        return round($amount * pow(10, $currency->getMinorUnit()), 0, $roundingMode);
    }
}