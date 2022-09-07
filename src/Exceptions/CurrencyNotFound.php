<?php

namespace Cyrtolat\Money\Exceptions;

class CurrencyNotFound extends MoneyException
{
    /**
     * Thrown when the currencies with specified code is not found.
     *
     * @return static
     */
    public static function create(string $code): self
    {
        return new static("Currency with the given code [$code] is not found.");
    }
}
