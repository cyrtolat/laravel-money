<?php

namespace Cyrtolat\Money\Tests\FakeEntities;

use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Currency;

class TestMoneyFormatter implements MoneyFormatter
{
    public function format(int $amount, Currency $currency): string
    {
        $subunit = pow(10, $currency->getMinorUnit());

        return sprintf('%s %s', $amount / $subunit, $currency->getAlphabeticCode());
    }
}