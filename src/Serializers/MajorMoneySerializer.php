<?php

namespace Cyrtolat\Money\Serializers;

use Cyrtolat\Money\Contracts\MoneySerializer;
use Cyrtolat\Money\Support\AmountHelper;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Money;

/**
 * Serializes a Money instance into an amount in a major currency style.
 */
final class MajorMoneySerializer implements MoneySerializer
{
    /**
     * {@inheritdoc}
     */
    public function toArray(Money $money, Currency $currency): array
    {
        return [
            'amount' => AmountHelper::calcMajorAmount($money->getAmount(), $currency),
            'currency' => $money->getCurrency()
        ];
    }
}
