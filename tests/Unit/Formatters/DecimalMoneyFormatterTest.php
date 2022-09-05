<?php

namespace Cyrtolat\Money\Tests\Unit\Formatters;

use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Formatters\DecimalMoneyFormatter;

class DecimalMoneyFormatterTest extends MoneyFormatterTest
{
    /** @var MoneyFormatter */
    protected MoneyFormatter $moneyFormatter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->moneyFormatter = new DecimalMoneyFormatter();
    }

    /** @test */
    public function test_formatting()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');
        $result = $this->moneyFormatter->format(15023, $currency);

        $this->assertSame('150.23 RUB', $result);
    }
}