<?php

namespace Cyrtolat\Money\Contracts;

use Cyrtolat\Money\Currency;

interface CurrencyStorage
{
    /**
     * Returns Currency for the specified code
     * or a null-value if the data does not exist.
     *
     * @param string $alphabeticCode Unique currency code
     * @return Currency|null New Currency instance or null
     */
    public function find(string $alphabeticCode): ?Currency;
}