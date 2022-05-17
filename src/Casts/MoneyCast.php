<?php

namespace Cyrtolat\Money\Casts;

use Cyrtolat\Money\Money;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Exceptions\MoneyCastException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

abstract class MoneyCast implements CastsAttributes
{
    /**
     * Currency code or a model attribute containing the currency code.
     *
     * @var string
     */
    protected $currency;

    /**
     * Instantiate the class.
     *
     * @param  string|null  $currency
     */
    public function __construct(string $currency = null)
    {
        if ($currency === null) {
            throw new MoneyCastException('Invalid data provided. The currency must be specified.');
        }

        $this->currency = $currency;
    }

    /**
     * Get the currency from an attribute value or cast parameter.
     *
     * @param  array  $attributes
     * @return \Cyrtolat\Money\Currency
     */
    protected function getCurrency(array $attributes)
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
     * @throws MoneyCastException If the currencies are different.
     */
    protected function validateCurrency(Money $money, Currency $currency): void
    {
        if ($money->getCurrency()->notEqualTo($currency)) {
            throw new MoneyCastException("Invalid data provided. The currency of given monies must be equal to the currency of the attribute.");
        }
    }
}
