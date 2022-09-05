<?php

namespace Cyrtolat\Money\Tests\Unit;

use Cyrtolat\Money\Helper;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Tests\TestCase;

class HelperTest extends TestCase
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
        $result = Helper::calcMajorAmount(150, $this->currency);

        $this->assertEquals(1.50, $result);
    }

    /** @test */
    public function test_calcMinorAmount()
    {
        $result = Helper::calcMinorAmount(1.532, $this->currency);

        $this->assertEquals(153, $result);
    }
}