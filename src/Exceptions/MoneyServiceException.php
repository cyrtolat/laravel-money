<?php

namespace Cyrtolat\Money\Exceptions;

class MoneyServiceException extends MoneyException
{
    /**
     * Thrown when the currencies with this code is not supported.
     *
     * @return static
     */
    public static function unknownCurrencyCode(string $code): self
    {
        return new static("Currency with the code \"$code\" is not found.");
    }
}
