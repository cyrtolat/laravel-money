<?php

namespace Cyrtolat\Money\Exceptions;

class CurrencyProviderException extends MoneyException
{
    /**
     * Thrown when the currency with a such alphabetic code doesn't exist.
     *
     * @return static
     */
    public static function alphabeticCodeDoesntExist($alphabeticCode): self
    {
        return new static("There is no Currency with such code: $alphabeticCode");
    }
}
