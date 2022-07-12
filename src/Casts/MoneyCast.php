<?php

namespace Cyrtolat\Money\Casts;

use Cyrtolat\Money\Money;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Exceptions\CurrencyProviderException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

abstract class MoneyCast implements CastsAttributes
{
    /**
     * Currency code or a model attribute containing the currency code.
     *
     * @var string
     */
    protected string $currency;

    /**
     * Instantiate the class.
     *
     * @param  string|null  $currency
     */
    public function __construct(string $currency = null)
    {
        if ($currency === null) {
            throw new InvalidArgumentException(
                "Invalid data provided. The currency must be specified.");
        }

        $this->currency = $currency;
    }

    /**
     * Get the currency from an attribute value or cast parameter.
     *
     * @param array $attributes
     * @return Currency
     * @throws CurrencyProviderException
     */
    protected function getCurrency(array $attributes): Currency
    {
        if (isset($attributes[$this->currency])) {
            return Currency::of($attributes[$this->currency]);
        }

        return Currency::of($this->currency);
    }

    /**
     * Checking the currency of the given monies and this attribute.
     *
     * @param Money $money The Money class instance.
     * @param Currency $currency The Currency class instance.
     */
    protected function validateCurrency(Money $money, Currency $currency): void
    {
        if (! $money->getCurrency()->equals($currency)) {
            throw new InvalidArgumentException(
                "The currency of given monies must be equal to the currency of the attribute.");
        }
    }
}
