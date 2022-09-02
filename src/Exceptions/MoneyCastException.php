<?php

namespace Cyrtolat\Money\Exceptions;

class MoneyCastException extends MoneyException
{
    /**
     * Thrown when the currency is not specified
     * in the cast attributes.
     *
     * @return static
     */
    public static function hasNotCurrency(): self
    {
        return new static("The currency should be specified.");
    }

    /**
     * Throws when the currency of the given money
     * does not match the currency of the cast.
     *
     * @return static
     */
    public static function setWrongCurrency(): self
    {
        return new static("The given value has wrong currency.");
    }
}
