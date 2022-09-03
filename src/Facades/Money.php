<?php

namespace Cyrtolat\Money\Facades;

use Cyrtolat\Money\MoneyService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \Cyrtolat\Money\Money ofMajor(float $amount, string|\Cyrtolat\Money\Currency $currency, int $roundingMode = PHP_ROUND_HALF_UP)
 * @method static \Cyrtolat\Money\Money ofMinor(int $amount, string|\Cyrtolat\Money\Currency $currency)
 * @method static \Cyrtolat\Money\Currency getCurrencyBy(string $code)
 *
 * @see \Cyrtolat\Money\MoneyService
 */
class Money extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor(): string
    {
        return MoneyService::class;
    }
}
