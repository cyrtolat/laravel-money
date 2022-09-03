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
        $amount = $money->getAmount();
        $degree = $currency->getMinorUnit();

        return [
            'amount' => $this->getMajorAmount($amount, $degree),
            'currency' => $money->getCurrency()
        ];
    }

    private function getMajorAmount(int $amount, int $degree): float
    {
        return $amount / pow(10, $degree);
    }
}
