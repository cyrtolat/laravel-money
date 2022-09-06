<?php

namespace Cyrtolat\Money\Tests\ServiceTests;

use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Contracts\MoneySerializer;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Money;
use Cyrtolat\Money\Services\MoneyService;
use Cyrtolat\Money\Tests\FakeEntities\TestCurrencyStorage;
use Cyrtolat\Money\Tests\FakeEntities\TestMoneyFormatter;
use Cyrtolat\Money\Tests\FakeEntities\TestMoneySerializer;

class ServiceClosuresTest extends MoneyServiceTest
{
    /** @test */
    public function test_formatter_callback()
    {
        $moneyService = new MoneyService([
            'storage' => TestCurrencyStorage::class,
            'formatter' => FirstMoneyFormatter::class,
            'serializer' => TestMoneySerializer::class
        ]);

        $money = new Money(150, 'RUB');

        $this->assertSame('first value', $money->render());

        $moneyService = new MoneyService([
            'storage' => TestCurrencyStorage::class,
            'formatter' => SecondMoneyFormatter::class,
            'serializer' => TestMoneySerializer::class
        ]);

        $money = new Money(150, 'RUB');

        $this->assertSame('second value', $money->render());
    }

    /** @test */
    public function test_serializer_callback()
    {
        $moneyService = new MoneyService([
            'storage' => TestCurrencyStorage::class,
            'formatter' => TestMoneyFormatter::class,
            'serializer' => FirstMoneySerializer::class
        ]);

        $money = new Money(150, 'RUB');

        $this->assertSame(['first value'], $money->toArray());

        $moneyService = new MoneyService([
            'storage' => TestCurrencyStorage::class,
            'formatter' => TestMoneyFormatter::class,
            'serializer' => SecondMoneySerializer::class
        ]);

        $money = new Money(150, 'RUB');

        $this->assertSame(['second value'], $money->toArray());
    }
}

// Some fake dependencies

class FirstMoneyFormatter implements MoneyFormatter
{
    public function format(int $amount, Currency $currency): string
    {
        return 'first value';
    }
}

class SecondMoneyFormatter implements MoneyFormatter
{
    public function format(int $amount, Currency $currency): string
    {
        return 'second value';
    }
}

class FirstMoneySerializer implements MoneySerializer
{
    public function toArray(int $amount, Currency $currency): array
    {
        return ['first value'];
    }
}

class SecondMoneySerializer implements MoneySerializer
{
    public function toArray(int $amount, Currency $currency): array
    {
        return ['second value'];
    }
}