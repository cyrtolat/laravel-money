<?php

namespace Cyrtolat\Money\Casts;

use Cyrtolat\Money\Money;
use Illuminate\Database\Eloquent\Model;

class MoneyDecimalCast extends MoneyCast
{
    /**
     * Transform the attribute from the underlying model values.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return Money|null
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return $value;
        }

        $currency = $this->getCurrency($attributes);

        return Money::of($value, $currency);
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param  Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return [$key => $value];
        }

        if (is_numeric($value)) {
            return [$key => $value];
        }

        if (array_key_exists($this->currency, $attributes)) {
            return [
                $key => $value->getAmount(),
                $this->currency => $value->getCurrency()->getAlphabeticCode()
            ];
        }

        $currency = $this->getCurrency($attributes);
        $this->validateCurrency($value, $currency);

        if ($value instanceof Money) {
            return [$key => $value->getAmount()];
        }

        throw new \InvalidArgumentException(
            "The given value must be a decimal or instance of Money class.");
    }
}
