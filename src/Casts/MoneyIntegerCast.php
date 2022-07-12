<?php

namespace Cyrtolat\Money\Casts;

use Cyrtolat\Money\Money;
use Illuminate\Database\Eloquent\Model;
use Cyrtolat\Money\Exceptions\CurrencyProviderException;
use InvalidArgumentException;

class MoneyIntegerCast extends MoneyCast
{
    /**
     * Transform the attribute from the underlying model values.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return Money|null
     * @throws CurrencyProviderException
     */
    public function get($model, string $key, $value, array $attributes): ?Money
    {
        if ($value === null) {
            return null;
        }

        $currency = $this->getCurrency($attributes);

        return Money::ofMinor($value, $currency);
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return array
     * @throws CurrencyProviderException
     */
    public function set($model, string $key, $value, array $attributes): array
    {
        if ($value === null) {
            return [$key => $value];
        }

        if (is_numeric($value) && (int) $value == $value) {
            return [$key => $value];
        }

        if (array_key_exists($this->currency, $attributes)) {
            return [
                $key => $value->getMinorAmount(),
                $this->currency => $value->getCurrency()->getAlphabeticCode()
            ];
        }

        $currency = $this->getCurrency($attributes);
        $this->validateCurrency($value, $currency);

        if ($value instanceof Money) {
            return [$key => $value->getMinorAmount()];
        }

        throw new InvalidArgumentException(
            "The given value must be an integer or instance of Money class.");
    }
}
