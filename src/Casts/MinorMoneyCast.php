<?php

namespace Cyrtolat\Money\Casts;

use Cyrtolat\Money\Money;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Services\MoneyService;
use Cyrtolat\Money\Exceptions\MoneyCastException;
use Cyrtolat\Money\Exceptions\MoneyServiceException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class MinorMoneyCast implements CastsAttributes
{
    /**
     * Currency code or a model attribute
     * containing the currency code.
     *
     * @var string
     */
    protected string $currency;

    /**
     * The service to create money instance.
     *
     * @var MoneyService
     */
    protected MoneyService $moneyService;

    /**
     * Instantiate the class.
     *
     * @param string|null $currency
     * @throws MoneyCastException
     * @throws BindingResolutionException
     */
    public function __construct(string $currency = null)
    {
        $this->moneyService = app()->make(MoneyService::class);

        if ($currency === null) {
            throw MoneyCastException::hasNotCurrency();
        }

        $this->currency = $currency;
    }

    /**
     * Get the currency from an attribute value or cast parameter.
     *
     * @param array $attributes
     * @return Currency
     * @throws MoneyServiceException
     */
    protected function getCurrency(array $attributes): Currency
    {
        if (isset($attributes[$this->currency])) {
            return $this->moneyService->getCurrencyBy(
                $attributes[$this->currency]
            );
        }

        return $this->moneyService->getCurrencyBy($this->currency);
    }

    /**
     * Transform the attribute from the underlying model values.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return Money|null
     * @throws MoneyServiceException
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }

        $currency = $this->getCurrency($attributes);

        return $this->moneyService->ofMinor($value, $currency);
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return array
     * @throws MoneyServiceException
     * @throws MoneyCastException
     */
    public function set($model, string $key, $value, array $attributes)
    {
        // If the null given
        if (is_null($value)) {
            return [$key => null];
        }

        // If the value is not null or Money instance
        if (!$value instanceof Money) {
            throw new \InvalidArgumentException(
                "The given value should to be a Money instance."
            );
        }

        // Getting Currency instance by the settings
        $currency = $this->getCurrency($attributes);

        // Creating a resulted array with a major-style amount
        $result = [$key => $value->getAmount()];

        // Add a new currency to the resulting array
        // when it is specified in the attributes
        if (isset($attributes[$this->currency])) {
            return array_merge($result, [
                $this->currency => $value->getCurrency()
            ]);
        }

        // If the given money currency is wrong
        if (! $currency->equals($value->getCurrency())) {
            throw MoneyCastException::setWrongCurrency();
        }

        // Or return only new attribute value
        // if the currency specified in params
        return $result;
    }
}
