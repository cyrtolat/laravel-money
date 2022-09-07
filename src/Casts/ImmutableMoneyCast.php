<?php

namespace Cyrtolat\Money\Casts;

use Cyrtolat\Money\Helper;
use Cyrtolat\Money\Money;
use Cyrtolat\Money\Services\MoneyService;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use InvalidArgumentException;

class ImmutableMoneyCast implements CastsAttributes
{
    /**
     * The service to create money instance.
     *
     * @var MoneyService
     */
    protected MoneyService $service;

    /**
     * Currency alphabetic code.
     *
     * @var string
     */
    protected string $currency;

    /**
     * If true, amount cast in monetary major-style.
     *
     * @var bool
     */
    protected bool $is_decimal;

    public function __construct(string $currency, string ...$other)
    {
        $this->service = app()->make(MoneyService::class);
        $this->is_decimal = in_array('decimal', $other);
        $this->currency = $currency;
    }

    public function get($model, string $key, $value, array $attributes)
    {
        if (is_null($value)) {
            return null;
        }

        if ($this->is_decimal && is_numeric($value)) {
            return $this->service->of($value, $this->currency);
        }

        if (! is_numeric($value) && $value != (int) $value) {
            throw new InvalidArgumentException(
                'The given amount should be an integer');
        }

        return $this->service->ofMinor($value, $this->currency);
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
            $currency = $this->service->getCurrencyOf($this->currency);
            return [$key => Helper::calcMajorAmount($value->getAmount(), $currency)];
        }

        return [$key => $value->getAmount()];
    }
}