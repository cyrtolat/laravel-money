<?php

namespace Cyrtolat\Money\Casts;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Money;

class IntegerMoneyCast extends TypedMoneyCast
{
    /**
     * {@inheritDoc}
     */
    protected function createSettableAmount(int $amount, Currency $currency): int
    {
        return $amount;
    }

    /**
     * {@inheritDoc}
     */
    protected function createGettableMoney(mixed $amount, Currency $currency): Money
    {
        if (! is_numeric($amount) && $amount != (int) $amount) {
            throw new \InvalidArgumentException('The given amount should be an integer');
        }

        return $this->moneyService->ofMinor($amount, $currency);
    }
}
