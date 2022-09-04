<?php

namespace Cyrtolat\Money\Serializers;

use Cyrtolat\Money\Contracts\MoneySerializer;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Money;

/**
 * Serializes a Money instance in a minor style.
 */
final class MinorMoneySerializer implements MoneySerializer
{
    /**
     * {@inheritdoc}
     */
    public function toArray(Money $money, Currency $currency): array
    {
        return [
            'amount' => $money->getAmount(),
            'currency' => $money->getCurrency()
        ];
    }
}
