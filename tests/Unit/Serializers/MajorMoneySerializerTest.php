<?php

namespace Cyrtolat\Money\Tests\Unit\Serializers;

use Cyrtolat\Money\Contracts\MoneySerializer;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Serializers\MajorMoneySerializer;

class MajorMoneySerializerTest extends MoneySerializerTest
{
    /** @var MoneySerializer */
    protected MoneySerializer $moneySerializer;

    protected function setUp(): void
    {
        parent::setUp();

        $this->moneySerializer = new MajorMoneySerializer();
    }

    /** @test */
    public function test_serialization()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');
        $result = $this->moneySerializer->toArray(15023, $currency);

        $this->assertSame([
            'amount' => 150.23,
            'currency' => 'RUB'
        ], $result);
    }
}