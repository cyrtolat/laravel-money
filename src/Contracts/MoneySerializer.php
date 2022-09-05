<?php

namespace Cyrtolat\Money\Contracts;

use Cyrtolat\Money\Currency;

interface MoneySerializer
{
    /**
     * Returns an array representation of monetary amount.
     *
     * @param integer $amount Monetary amount to serialize
     * @param Currency $currency The Currency instance
     * @return array
     */
    public function toArray(int $amount, Currency $currency): array;
}
