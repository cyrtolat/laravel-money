<?php

namespace Cyrtolat\Money\Tests\ServiceTests;

use Cyrtolat\Money\Contracts\CurrencyStorage;
use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Contracts\MoneySerializer;
use Cyrtolat\Money\Services\MoneyService;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Money;

class ServiceClosuresTest extends MoneyServiceTest
{
    /** @test */
    public function test_formatter_callback()
    {
        $moneyService = new MoneyService([
            'storage' => TestCurrencyStorage::class,
            'formatter' => FirstMoneyFormatter::class,
            'serializer' => FirstMoneySerializer::class
        ]);

        $money = new Money(150, 'RUB');

        $this->assertSame('first value', $money->render());

        $moneyService = new MoneyService([
            'storage' => TestCurrencyStorage::class,
            'formatter' => SecondMoneyFormatter::class,
            'serializer' => FirstMoneySerializer::class
        ]);

        $money = new Money(150, 'RUB');

        $this->assertSame('second value', $money->render());
    }

    /** @test */
    public function test_serializer_callback()
    {
        $moneyService = new MoneyService([
            'storage' => TestCurrencyStorage::class,
            'formatter' => FirstMoneyFormatter::class,
            'serializer' => FirstMoneySerializer::class
        ]);

        $money = new Money(150, 'RUB');

        $this->assertSame(['first value'], $money->toArray());

        $moneyService = new MoneyService([
            'storage' => TestCurrencyStorage::class,
            'formatter' => FirstMoneyFormatter::class,
            'serializer' => SecondMoneySerializer::class
        ]);

        $money = new Money(150, 'RUB');

        $this->assertSame(['second value'], $money->toArray());
    }
}

// Some fake dependencies

class TestCurrencyStorage implements CurrencyStorage
{
    public function find(string $alphabeticCode): ?Currency
    {
        $currencies = [
            'RUB' => new Currency('RUB', '643', 2, 'Russia Ruble'),
            'USD' => new Currency('USD', '840', 2, 'US Dollar'),
            'EUR' => new Currency('EUR', '978', 2, 'Euro')
        ];

        if (isset($currencies[$alphabeticCode])) {
            return clone $currencies[$alphabeticCode];
        }

        return null;
    }
}

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