<?php

namespace Cyrtolat\Money\Exceptions;

class MoneyCalculatorException extends MoneyException
{
    /**
     * Thrown when the currencies differ.
     *
     * @return static
     */
    public static function differentCurrencies(): self
    {
        return new static(
            "It is impossible to perform mathematical operations with monies with different currencies.");
    }
}
