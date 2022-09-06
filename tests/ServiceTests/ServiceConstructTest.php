<?php

namespace Cyrtolat\Money\Tests\ServiceTests;

use Cyrtolat\Money\Services\MoneyService;
use Cyrtolat\Money\Tests\FakeEntities\FakeCurrencyStorage;
use Cyrtolat\Money\Tests\FakeEntities\FakeMoneyFormatter;
use Cyrtolat\Money\Tests\FakeEntities\FakeMoneySerializer;

class ServiceConstructTest extends MoneyServiceTest
{
    /** @test */
    public function test_when_dependencies_not_specified()
    {
        $this->expectException(\RuntimeException::class);

        new MoneyService([
            'storage' => null,
            'formatter' => null,
            'serializer' => null
        ]);
    }

    /** @test */
    public function test_when_wrong_config_types()
    {
        $this->expectException(\RuntimeException::class);

        new MoneyService([
            'storage' => true,
            'formatter' => 'not a class',
            'serializer' => []
        ]);
    }

    /** @test */
    public function test_when_wrong_dependencies()
    {
        $this->expectException(\RuntimeException::class);

        new MoneyService([
            'storage' => FakeMoneySerializer::class,
            'formatter' => FakeCurrencyStorage::class,
            'serializer' => FakeMoneyFormatter::class
        ]);
    }
}