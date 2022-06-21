<?php

namespace Cyrtolat\Money\Traits\Currency;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Exceptions\CurrencyProviderException;
use Cyrtolat\Money\Providers\MoneyCurrencyProvider;

/**
 * The Currency factory trait.
 */
trait HasFactory
{
    /**
     * Returns the Currency instance.
     *
     * @param string $code The alphabetical currency code.
     * @return Currency
     * @throws CurrencyProviderException
     */
    public static function of(string $code): Currency
    {
        $provider = MoneyCurrencyProvider::getInstance();

        return $provider->getCurrency($code);
    }
}
