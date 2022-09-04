<?php

namespace Cyrtolat\Money\Exceptions;

class CurrencyValidationException extends MoneyException
{
    /**
     * Thrown when the currency alphabetic code has wrong format.
     *
     * @return static
     */
    public static function invalidAlphabeticCode(): self
    {
        return new static("The alphabetic code should consist of 3 or 4 capital letters.");
    }

    /**
     * Thrown when the currency numeric code has wrong format.
     *
     * @return static
     */
    public static function invalidNumericCode(): self
    {
        return new static("The numeric code should consist only of digits.");
    }

    /**
     * Thrown when the currency minor unit has wrong format.
     *
     * @return static
     */
    public static function invalidMinorUnit(): self
    {
        return new static("The minor unit must be greater than zero.");
    }
}