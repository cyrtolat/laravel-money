<?php

namespace Cyrtolat\Money\Tests\Entities;

use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Currency;

class FakeMoneyFormatter implements MoneyFormatter
{
    public function format(int $amount, Currency $currency): string
    {
        $majorAmount = $amount / pow(10, $currency->minorUnit);

        return sprintf('%s %s', $majorAmount, $currency->alphabeticCode);
    }
}