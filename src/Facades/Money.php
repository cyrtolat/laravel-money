<?php

namespace Cyrtolat\Money\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Cyrtolat\Money\Currency currency(string $alphabeticCode)
 * @method static \Cyrtolat\Money\Money ofMinor(int $amount, string|\Cyrtolat\Money\Currency $currency)
 * @method static \Cyrtolat\Money\Money of(float $amount, string|\Cyrtolat\Money\Currency $currency, int $roundingMode = PHP_ROUND_HALF_UP)
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
        return 'money';
    }
}
