<?php

namespace Cyrtolat\Money\Tests\ServiceTests;

use Cyrtolat\Money\Services\MoneyService;
use Cyrtolat\Money\Tests\FakeEntities\TestCurrencyStorage;
use Cyrtolat\Money\Tests\FakeEntities\TestMoneyFormatter;
use Cyrtolat\Money\Tests\FakeEntities\TestMoneySerializer;

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
            'storage' => TestMoneySerializer::class,
            'formatter' => TestCurrencyStorage::class,
            'serializer' => TestMoneyFormatter::class
        ]);
    }
}