<?php

namespace Cyrtolat\Money\Contracts;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Money;

interface MoneySerializer
{
    /**
     * Returns an array representation of an instance of Money class.
     *
     * @param Money $money The Money instance to serialize
     * @param Currency $currency The Currency instance
     * @return array
     */
    public function toArray(Money $money, Currency $currency): array;
}
