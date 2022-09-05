<?php

namespace Cyrtolat\Money\Serializers;

use Cyrtolat\Money\Contracts\MoneySerializer;
use Cyrtolat\Money\Support\AmountHelper;
use Cyrtolat\Money\Currency;

/**
 * Serializes a Money instance in a major style.
 */
final class MajorMoneySerializer implements MoneySerializer
{
    /**
     * {@inheritdoc}
     */
    public function toArray(int $amount, Currency $currency): array
    {
        return [
            'amount' => AmountHelper::calcMajorAmount($amount, $currency),
            'currency' => $currency->getAlphabeticCode()
        ];
    }
}
