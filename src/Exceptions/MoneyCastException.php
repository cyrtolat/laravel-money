<?php

namespace Cyrtolat\Money\Exceptions;

class MoneyCastException extends MoneyException
{
    /**
     * Thrown when the attribute currency is not identical to the given.
     *
     * @return static
     */
    public static function attributeCurrencyMismatch(string $given, string $attr): self
    {
        return new static("The currency of given Money [$given] mismatch to the attribute currency [$attr].");
    }

    /**
     * Thrown when the attribute doesn't have a currency.
     *
     * @return static
     */
    public static function attributeCurrencyUnset(): self
    {
        return new static("The currency of attribute is unset");
    }
}