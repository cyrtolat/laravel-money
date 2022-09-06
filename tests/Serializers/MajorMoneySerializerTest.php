<?php

namespace Cyrtolat\Money\Tests\Serializers;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Serializers\MajorMoneySerializer;

class MajorMoneySerializerTest extends MoneySerializerTest
{
    /** @test */
    public function test_toArray_method()
    {
        $moneySerializer = new MajorMoneySerializer();
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');
        $result = $moneySerializer->toArray(15023, $currency);

        $this->assertSame([
            'amount' => 150.23,
            'currency' => 'RUB'
        ], $result);
    }
}