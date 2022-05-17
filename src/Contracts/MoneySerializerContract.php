<?php

namespace Cyrtolat\Money\Contracts;

use Cyrtolat\Money\Money;

/**
 * Serializes Money objects.
 */
interface MoneySerializerContract
{
    /**
     * Returns an array representation of an instance of Money class.
     *
     * @param Money $money The Money class instance.
     * @param array $params The array of params to formatting.
     * @return array
     */
    public function toArray(Money $money, array $params = []): array;
}
