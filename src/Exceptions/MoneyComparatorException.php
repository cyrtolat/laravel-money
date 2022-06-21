<?php

namespace Cyrtolat\Money\Exceptions;

class MoneyComparatorException extends MoneyException
{
    /**
     * Thrown when the currencies differ.
     *
     * @return static
     */
    public static function differentCurrencies(): self
    {
        return new static("Impossible to compare monies with different currencies.");
    }
}
