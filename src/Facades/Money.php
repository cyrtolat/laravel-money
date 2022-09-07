<?php

namespace Cyrtolat\Money\Facades;

use Cyrtolat\Money\Services\MoneyService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Cyrtolat\Money\Money of(float $amount, string|\Cyrtolat\Money\Currency $currency, int $roundingMode = PHP_ROUND_HALF_UP)
 * @method static \Cyrtolat\Money\Money ofMinor(int $amount, string|\Cyrtolat\Money\Currency $currency)
 * @method static \Cyrtolat\Money\Currency getCurrencyOf(string $code)
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
