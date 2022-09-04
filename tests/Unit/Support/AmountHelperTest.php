<?php

namespace Cyrtolat\Money\Tests\Unit\Support;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Support\AmountHelper;
use Cyrtolat\Money\Tests\TestCase;

class AmountHelperTest extends TestCase
{
    /** @var Currency */
    protected Currency $currency;

    protected function setUp(): void
    {
        $this->currency = new Currency('RUB', '643', 2, 'Russian Ruble');
    }

    /** @test */
    public function test_calcMajorAmount()
    {
        $result = AmountHelper::calcMajorAmount(150, $this->currency);

        $this->assertEquals(1.50, $result);
    }

    /** @test */
    public function test_calcMinorAmount()
    {
        $result = AmountHelper::calcMinorAmount(1.532, $this->currency);

        $this->assertEquals(153, $result);
    }
}