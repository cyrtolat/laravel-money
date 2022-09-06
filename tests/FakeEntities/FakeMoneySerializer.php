<?php

namespace Cyrtolat\Money\Tests\FakeEntities;

use Cyrtolat\Money\Contracts\MoneySerializer;
use Cyrtolat\Money\Currency;

class FakeMoneySerializer implements MoneySerializer
{
    public function toArray(int $amount, Currency $currency): array
    {
        $subunit = pow(10, $currency->getMinorUnit());

        return [
            'amount' => $amount / $subunit,
            'currency' => $currency->getAlphabeticCode()
        ];
    }
}