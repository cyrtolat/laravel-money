<?php

namespace Cyrtolat\Money\Exceptions;

class CurrencyMismatch extends MoneyException
{
    /**
     * Thrown when the required currency is not identical to the given.
     *
     * @return static
     */
    public static function create(string $given, string $required): self
    {
        return new static("The currency of given Money [$given] mismatch to the required [$required].");
    }
}