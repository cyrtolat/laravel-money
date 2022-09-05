<?php

namespace Cyrtolat\Money\Tests\Unit\Serializers;

use Cyrtolat\Money\Contracts\MoneySerializer;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Serializers\MinorMoneySerializer;

class MinorMoneySerializerTest extends MoneySerializerTest
{
    /** @var MoneySerializer */
    protected MoneySerializer $moneySerializer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->moneySerializer = new MinorMoneySerializer();
    }

    /** @test */
    public function test_serialization()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');
        $result = $this->moneySerializer->toArray(15023, $currency);

        $this->assertSame([
            'amount' => 15023,
            'currency' => 'RUB'
        ], $result);
    }
}