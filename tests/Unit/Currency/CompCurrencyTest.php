<?php

namespace Cyrtolat\Money\Tests\Unit\Currency;

use Cyrtolat\Money\Currency;

class CompCurrencyTest extends CurrencyTest
{
    /** @test */
    public function test_equals_by_string_alphabetic_code()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');

        $this->assertTrue($currency->equals('RUB'));
    }

    /** @test */
    public function test_equals_by_currency_instance()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');

        $this->assertTrue($currency->equals(
            new Currency('RUB', '643', 2, 'Russian Ruble')
        ));

        $this->assertFalse($currency->equals(
            new Currency('RUB', '810', 2, 'Old Russian Ruble')
        ));
    }
}