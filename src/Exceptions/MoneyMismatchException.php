<?php

namespace Cyrtolat\Money\Exceptions;

class MoneyMismatchException extends MoneyException
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