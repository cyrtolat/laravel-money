<?php

namespace Cyrtolat\Money\Serializers;

use Cyrtolat\Money\Contracts\MoneySerializerContract;
use Cyrtolat\Money\Money;

/**
 * Serializes an instance of the Money class in a major currency unit as a decimal.
 */
class MoneyDecimalSerializer implements MoneySerializerContract
{
    /** {@inheritdoc} */
    public function toArray(Money $money, array $params = []): array
    {
        return [
            'amount' => $money->getMajorAmount(),
            'currency' => $money->getCurrency()->getAlphabeticCode()
        ];
    }
}
