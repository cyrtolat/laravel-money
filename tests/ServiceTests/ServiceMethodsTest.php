<?php

namespace Cyrtolat\Money\Tests\ServiceTests;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Services\MoneyService;
use Cyrtolat\Money\Exceptions\MoneyServiceException;
use Cyrtolat\Money\Tests\FakeEntities\FakeCurrencyStorage;
use Cyrtolat\Money\Tests\FakeEntities\FakeMoneyFormatter;
use Cyrtolat\Money\Tests\FakeEntities\FakeMoneySerializer;

class ServiceMethodsTest extends MoneyServiceTest
{
    /** @var MoneyService */
    protected MoneyService $moneyService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->moneyService = new MoneyService([
            'storage' => FakeCurrencyStorage::class,
            'formatter' => FakeMoneyFormatter::class,
            'serializer' => FakeMoneySerializer::class
        ]);
    }

    /** @test */
    public function test_get_currency_of_method()
    {
        $result = $this->moneyService->getCurrencyOf('RUB');

        $this->assertTrue($result instanceof Currency);

        $this->expectException(MoneyServiceException::class);

        $this->moneyService->getCurrencyOf('XYZ');
    }

    /** @test */
    public function test_of_method()
    {
        $result = $this->moneyService->of(150.23, 'RUB');

        $this->assertTrue($result->getAmount() == 15023);
        $this->assertTrue($result->getCurrency() == 'RUB');

        $this->expectException(MoneyServiceException::class);

        $this->moneyService->of(150, 'XYZ');
    }

    /** @test */
    public function test_of_minor_method()
    {
        $result = $this->moneyService->ofMinor(15023, 'RUB');

        $this->assertTrue($result->getAmount() == 15023);
        $this->assertTrue($result->getCurrency() == 'RUB');

        $this->expectException(MoneyServiceException::class);

        $this->moneyService->of(150, 'XYZ');
    }
}