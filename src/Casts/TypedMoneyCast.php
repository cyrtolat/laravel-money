<?php

namespace Cyrtolat\Money\Casts;

use Cyrtolat\Money\Money;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Services\MoneyService;
use Cyrtolat\Money\Exceptions\MoneyCastException;
use Cyrtolat\Money\Exceptions\MoneyServiceException;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

abstract class TypedMoneyCast implements CastsAttributes
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
     * The class constructor.
     *
     * @param string|null $currency
     * @throws MoneyCastException
     * @throws BindingResolutionException
     */
    public function __construct(string $currency = null)
    {
        $this->moneyService = app()->make(MoneyService::class);

        if ($currency === null) {
            throw MoneyCastException::attributeCurrencyUnset();
        }

        $this->currency = $currency;
    }

    /**
     * {@inheritDoc}
     * @throws MoneyServiceException
     */
    public function get($model, string $key, $value, array $attributes)
    {
        // If the null given
        if (is_null($value)) {
            return [$key => null];
        }

        // Getting the Currency instance by attr settings
        $currency = $this->getCurrencyObject($attributes);

        // Returns new Money instance by the attr settings
        return $this->createGettableMoney($value, $currency);
    }

    /**
     * {@inheritDoc}
     * @throws MoneyServiceException|MoneyCastException
     */
    public function set($model, string $key, $value, array $attributes)
    {
        // If the null given
        if (is_null($value)) {
            return [$key => null];
        }

        // If the value is not Money instance
        if (!$value instanceof Money) {
            throw new \InvalidArgumentException(
                "The given value should to be a Money instance."
            );
        }

        // Getting the Currency instance by attr settings
        $currency = $this->getCurrencyObject($attributes);

        // Creating resulted array with a major-style monetary amount
        $result = [$key => $this->createSettableAmount(
            $value->getAmount(), $currency)];

        // Sets a new currency to the result array
        // when it is specified in the attributes
        if (isset($attributes[$this->currency])) {
            return array_merge($result, [
                $this->currency => $value->getCurrency()
            ]);
        }

        // If the given money currency mismatch to attr
        if (! $currency->equals($value->getCurrency())) {
            throw MoneyCastException::attributeCurrencyMismatch(
                $value->getCurrency(), $currency->getAlphabeticCode());
        }

        return $result;
    }

    /**
     * Get the currency instance from an attribute value or cast parameter.
     *
     * @param array $attributes
     * @return Currency
     * @throws MoneyServiceException
     */
    protected function getCurrencyObject(array $attributes): Currency
    {
        if (isset($attributes[$this->currency])) {
            return $this->moneyService->getCurrencyBy(
                $attributes[$this->currency]
            );
        }

        return $this->moneyService->getCurrencyBy($this->currency);
    }

    /**
     * @param int $amount
     * @param Currency $currency
     * @return mixed
     */
    abstract protected function createSettableAmount(int $amount, Currency $currency): mixed;

    /**
     * @param mixed $amount
     * @param Currency $currency
     * @return Money
     */
    abstract protected function createGettableMoney(mixed $amount, Currency $currency): Money;
}