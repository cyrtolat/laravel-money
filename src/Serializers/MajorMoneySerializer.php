<?php

namespace Cyrtolat\Money\Serializers;

use Cyrtolat\Money\Contracts\MoneySerializer;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Money;

final class MajorMoneySerializer implements MoneySerializer
{
    /**
     * {@inheritdoc}
     */
    public function toArray(Money $money, Currency $currency): array
    {
        return [
            'amount' => $this->getMajorAmount($money, $currency),
            'currency' => $money->getCurrency()
        ];
    }

    /**
     * Todo desc..
     *
     * @param Money $money
     * @param Currency $currency
     * @return float
     */
    private function getMajorAmount(Money $money, Currency $currency): float
    {
        return $money->getAmount() / pow(10, $currency->getMinorUnit());
    }
}
