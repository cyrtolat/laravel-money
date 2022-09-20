<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\Services\MoneyService;
use Cyrtolat\Money\Tests\Entities\FakeCurrencyStorage;
use Cyrtolat\Money\Tests\Entities\FakeMoneyFormatter;
use Cyrtolat\Money\Tests\Entities\FakeMoneySerializer;

class HelpersTest extends TestCase
{
    /** @var MoneyService */
    protected MoneyService $service;

    protected function resolveApplicationConfiguration($app)
    {
        parent::resolveApplicationConfiguration($app);

        $app['config']->set('money.currency', 'EUR');
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = new MoneyService([
            'storage' => FakeCurrencyStorage::class,
            'formatter' => FakeMoneyFormatter::class,
            'serializer' => FakeMoneySerializer::class
        ]);
    }

    /** @test */
    public function money()
    {
        $money = $this->service->of(1.50, 'EUR');

        $this->assertTrue($money->hasSameAmount(money(150)));
        $this->assertTrue($money->hasSameCurrency(money(150)));

        $money = $this->service->of(1.50, 'RUB');

        $this->assertTrue($money->hasSameAmount(money(150)));
        $this->assertFalse($money->hasSameCurrency(money(150)));
        $this->assertTrue($money->hasSameCurrency(money(150, 'RUB')));
    }

    /** @test */
    public function currency()
    {
        $currency = $this->service->getCurrencyOf('EUR');

        $this->assertTrue($currency->equals(currency()));
        $this->assertFalse($currency->equals(currency('USD')));
    }

    /** @test */
    public function test_calcMajorAmount_method()
    {
        $currency = $this->service->getCurrencyOf('RUB');
        $result = calcMajorAmount(150, $currency);

        $this->assertEquals(1.50, $result);
    }

    /** @test */
    public function test_calcMinorAmount_method()
    {
        $currency = $this->service->getCurrencyOf('RUB');
        $result = calcMinorAmount(1.532, $currency);

        $this->assertEquals(153, $result);
    }
}