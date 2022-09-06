<?php

namespace Cyrtolat\Money\Casts;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Helper;
use Cyrtolat\Money\Money;

final class DecimalMoneyCast extends TypedMoneyCast
{
    /**
     * {@inheritDoc}
     */
    protected function createSettableAmount(int $amount, Currency $currency): float
    {
        return Helper::calcMajorAmount($amount, $currency);
    }

    /**
     * {@inheritDoc}
     */
    protected function createGettableMoney(mixed $amount, Currency $currency): Money
    {
        if (! is_numeric($amount)) {
            throw new \InvalidArgumentException('The given amount should be a numeric');
        }

        return $this->moneyService->of($amount, $currency);
    }
}
