<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\Helper;
use Cyrtolat\Money\Currency;

class HelperTest extends TestCase
{
    /** @test */
    public function test_calcMajorAmount_method()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');
        $result = Helper::calcMajorAmount(150, $currency);

        $this->assertEquals(1.50, $result);
    }

    /** @test */
    public function test_calcMinorAmount_method()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');
        $result = Helper::calcMinorAmount(1.532, $currency);

        $this->assertEquals(153, $result);
    }
}