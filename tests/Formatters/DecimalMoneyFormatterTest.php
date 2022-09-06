<?php

namespace Cyrtolat\Money\Tests\Formatters;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Formatters\DecimalMoneyFormatter;

class DecimalMoneyFormatterTest extends MoneyFormatterTest
{
    /** @test */
    public function test_format_method()
    {
        $moneyFormatter = new DecimalMoneyFormatter();
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');
        $result = $moneyFormatter->format(15023, $currency);

        $this->assertSame('150.23 RUB', $result);
    }
}