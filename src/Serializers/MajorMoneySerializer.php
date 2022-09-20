<?php

namespace Cyrtolat\Money\Serializers;

use Cyrtolat\Money\Contracts\MoneySerializer;
use Cyrtolat\Money\Currency;

/**
 * Serializes a monetary amount in a major style.
 */
final class MajorMoneySerializer implements MoneySerializer
{
    /**
     * {@inheritdoc}
     */
    public function toArray(int $amount, Currency $currency): array
    {
        return [
            'amount' => calcMajorAmount($amount, $currency),
            'currency' => $currency->getAlphabeticCode()
        ];
    }
}
