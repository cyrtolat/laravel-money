<?php

namespace Cyrtolat\Money\Contracts;

use Cyrtolat\Money\Currency;

interface MoneyFormatter
{
    /**
     * Returns a string representation of monetary amount.
     *
     * @param integer $amount Monetary amount to format
     * @param Currency $currency Currency instance
     * @return string
     */
    public function format(int $amount, Currency $currency): string;
}
