<?php

namespace Cyrtolat\Money\Tests\Formatters;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Formatters\LocalizedMoneyFormatter;

class LocalizedMoneyFormatterTest extends MoneyFormatterTest
{
    /** @test */
    public function test_format_method()
    {
        $moneyFormatter = new LocalizedMoneyFormatter();
        $currency = new Currency('USD', '840', 2, 'US Dollar');
        $result = $moneyFormatter->format(15023, $currency);

        $this->assertSame('$150.23', $result);
    }
}