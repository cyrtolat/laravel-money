<?php

namespace Cyrtolat\Money\Tests\Dependencies;

use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Currency;

class FakeMoneyFormatter implements MoneyFormatter
{
    public function format(int $amount, Currency $currency): string
    {
        $subunit = pow(10, $currency->getMinorUnit());

        return sprintf('%s %s', $amount / $subunit, $currency->getAlphabeticCode());
    }
}