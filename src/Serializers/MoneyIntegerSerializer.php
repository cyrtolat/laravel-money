<?php

namespace Cyrtolat\Money\Serializers;

use Cyrtolat\Money\Money;
use Cyrtolat\Money\Contracts\MoneySerializerContract;

/**
 * Serializes an instance of the Money class in a minor currency unit as an integer.
 */
class MoneyIntegerSerializer implements MoneySerializerContract
{
    /** {@inheritdoc} */
    public function toArray(Money $money, array $params = []): array
    {
        return [
            'amount' => $money->getMinorAmount(),
            'currency' => $money->getCurrency()->getAlphabeticCode()
        ];
    }
}
