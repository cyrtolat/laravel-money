<?php

namespace Cyrtolat\Money\Facades;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Services\MoneyService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Cyrtolat\Money\Money ofMajor(float $amount, string|Currency $currency, int $roundingMode = PHP_ROUND_HALF_UP)
 * @method static \Cyrtolat\Money\Money ofMinor(int $amount, string|Currency $currency)
 * @method static Currency getCurrencyBy(string $code)
 *
 * @see \Cyrtolat\Money\MoneyService
 */
class Money extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MoneyService::class;
    }
}
