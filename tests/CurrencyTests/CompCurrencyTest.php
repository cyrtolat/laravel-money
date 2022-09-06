<?php

namespace Cyrtolat\Money\Tests\CurrencyTests;

use Cyrtolat\Money\Currency;

class CompCurrencyTest extends CurrencyTest
{
    /** @test */
    public function test_equals_by_currency_code()
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

        $this->assertFalse($currency->equals( // Wrong numeric code
            new Currency('RUB', '810', 2, 'Russian Ruble')
        ));

        $this->assertFalse($currency->equals( // Wrong minor unit
            new Currency('RUB', '643', 4, 'Russian Ruble')
        ));

        $this->assertFalse($currency->equals( // Wrong entity
            new Currency('RUB', '643', 2, 'Old Russian Ruble')
        ));
    }
}