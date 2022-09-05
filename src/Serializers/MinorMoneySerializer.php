<?php

namespace Cyrtolat\Money\Serializers;

use Cyrtolat\Money\Contracts\MoneySerializer;
use Cyrtolat\Money\Currency;

/**
 * Serializes a Money instance in a minor style.
 */
final class MinorMoneySerializer implements MoneySerializer
{
    /**
     * {@inheritdoc}
     */
    public function toArray(int $amount, Currency $currency): array
    {
        return [
            'amount' => $amount,
            'currency' => $currency->getAlphabeticCode()
        ];
    }
}
