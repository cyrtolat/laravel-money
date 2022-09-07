<?php

namespace Cyrtolat\Money\Casts;

use Cyrtolat\Money\Helper;
use Cyrtolat\Money\Money;
use Cyrtolat\Money\Services\MoneyService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

class AssignableMoneyCast implements CastsAttributes
{
    /**
     * The service to create money instance.
     *
     * @var MoneyService
     */
    protected MoneyService $service;

    /**
     * model attribute containing the currency code.
     *
     * @var string
     */
    protected string $attribute;

    /**
     * If true, amount cast in monetary major-style.
     *
     * @var bool
     */
    protected bool $is_decimal;

    public function __construct(string $attribute, string ...$other)
    {
        $this->service = app()->make(MoneyService::class);
        $this->is_decimal = in_array('decimal', $other);
        $this->attribute = $attribute;
    }

    public function get($model, string $key, $value, array $attributes)
    {
        if (is_null($value)) {
            return null;
        }

        if (! isset($attributes[$this->attribute])) {
            throw new \RuntimeException('Currency not provided.');
        }

        if ($this->is_decimal && is_numeric($value)) {
            return $this->service->of($value, $attributes[$this->attribute]);
        }

        if (! is_numeric($value) && $value != (int) $value) {
            throw new InvalidArgumentException(
                'The given amount should be an integer');
        }

        return $this->service->ofMinor($value, $attributes[$this->attribute]);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if (is_null($value)) {
            return [$key => null];
        }

        if (! $value instanceof Money) {
            throw new InvalidArgumentException(
                "The given value should to be a Money instance.");
        }

        if ($this->is_decimal) {
            $currency = $this->service->getCurrencyOf($value->getCurrency());
            return [
                $key => Helper::calcMajorAmount($value->getAmount(), $currency),
                $this->attribute => $value->getCurrency()
            ];
        }

        return [
            $key => $value->getAmount(),
            $this->attribute => $value->getCurrency()
        ];
    }
}