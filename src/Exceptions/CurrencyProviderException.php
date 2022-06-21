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

    /**
     * Thrown when the currency with a such alphabetic code already exists.
     *
     * @return static
     */
    public static function alphabeticCodeAlreadyExists($alphabeticCode): self
    {
        return new static("An ISO-currency with such alphabetic code [$alphabeticCode] already exists.");
    }

    /**
     * Thrown when the currency with a such alphabetic code already registered.
     *
     * @return static
     */
    public static function currencyAlreadyRegistered($alphabeticCode): self
    {
        return new static("A currency with such alphabetic code [$alphabeticCode] already registered.");
    }
}
