<?php

namespace Cyrtolat\Money\Tests\Unit\Formatters;

use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Formatters\LocalizedMoneyFormatter;

class LocalizedMoneyFormatterTest extends MoneyFormatterTest
{
    /** @var MoneyFormatter */
    protected MoneyFormatter $moneyFormatter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->moneyFormatter = new LocalizedMoneyFormatter();
    }

    /** @test */
    public function test_with_fraction_part()
    {
        $currency = new Currency('USD', '840', 2, 'US Dollar');
        $result = $this->moneyFormatter->format(15023, $currency);

        $this->assertSame('$150.23', $result);
    }
}