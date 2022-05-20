<?php

namespace Cyrtolat\Money\Casts;

use Cyrtolat\Money\Money;
use Cyrtolat\Money\Exceptions\MoneyCastException;

class MoneyDecimalCast extends MoneyCast
{
    /**
     * Transform the attribute from the underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return \Cyrtolat\Money\Money|null
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return $value;
        }

        $currency = $this->getCurrency($attributes);

        return Money::ofMajor($value, $currency);
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return [$key => $value];
        }

        if (is_numeric($value)) {
            return [$key => $value];
        }

        if ($value instanceof Money) {
            $currency = $this->getCurrency($attributes);
            $this->validateCurrency($value, $currency);

            return [$key => $value->getMajorAmount()];
        }

        throw new MoneyCastException("Invalid data provided. The given value must be a decimal or instance of Money class.");
    }
}
