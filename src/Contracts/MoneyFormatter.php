<?php

namespace Cyrtolat\Money\Contracts;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Money;

interface MoneyFormatter
{
    /**
     * Formats a Money instance as a string.
     *
     * @param Money $money
     * @param Currency $currency
     * @return string
     */
    public function format(Money $money, Currency $currency): string;
}
