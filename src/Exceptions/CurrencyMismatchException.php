<?php

namespace Cyrtolat\Money\Exceptions;

class CurrencyMismatchException extends MoneyException
{
    /**
     * Thrown when the currencies not identical.
     *
     * @return static
     */
    public static function hasNotSameCurrency(): self
    {
        return new static("Currencies must be identical.");
    }
}