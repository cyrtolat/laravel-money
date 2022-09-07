<?php

namespace Cyrtolat\Money\Tests\Entities;

use Cyrtolat\Money\Contracts\MoneySerializer;
use Cyrtolat\Money\Currency;

class FakeMoneySerializer implements MoneySerializer
{
    public function toArray(int $amount, Currency $currency): array
    {
        return [
            'amount' => $amount / pow(10, $currency->getMinorUnit()),
            'currency' => $currency->getAlphabeticCode()
        ];
    }
}