<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\Exceptions\CurrencyNotFound;
use Cyrtolat\Money\Money;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Contracts\CurrencyStorage;
use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Contracts\MoneySerializer;
use Cyrtolat\Money\Services\MoneyService;
use Cyrtolat\Money\Tests\Entities\FakeCurrencyStorage;
use Cyrtolat\Money\Tests\Entities\FakeMoneyFormatter;
use Cyrtolat\Money\Tests\Entities\FakeMoneySerializer;

class ServiceTest extends TestCase
{
    /** @test */
    public function formatter_callback()
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
    public function serializer_callback()
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

    /** @test */
    public function when_dependencies_not_specified()
    {
        $this->expectException(\RuntimeException::class);

        new MoneyService([
            'storage' => null,
            'formatter' => null,
            'serializer' => null
        ]);
    }

    /** @test */
    public function when_wrong_config_types()
    {
        $this->expectException(\RuntimeException::class);

        new MoneyService([
            'storage' => true,
            'formatter' => 'not a class',
            'serializer' => []
        ]);
    }

    /** @test */
    public function when_wrong_dependencies()
    {
        $this->expectException(\RuntimeException::class);

        new MoneyService([
            'storage' => FakeMoneySerializer::class,
            'formatter' => FakeCurrencyStorage::class,
            'serializer' => FakeMoneyFormatter::class
        ]);
    }

    /** @test */
    public function get_currency_of_method()
    {
        $moneyService = new MoneyService([
            'storage' => FakeCurrencyStorage::class,
            'formatter' => FakeMoneyFormatter::class,
            'serializer' => FakeMoneySerializer::class
        ]);

        $result = $moneyService->getCurrencyOf('RUB');

        $this->assertTrue($result instanceof Currency);

        $this->expectException(CurrencyNotFound::class);

        $moneyService->getCurrencyOf('XYZ');
    }

    /** @test */
    public function of_method()
    {
        $moneyService = new MoneyService([
            'storage' => FakeCurrencyStorage::class,
            'formatter' => FakeMoneyFormatter::class,
            'serializer' => FakeMoneySerializer::class
        ]);

        $result = $moneyService->of(150.23, 'RUB');

        $this->assertTrue($result->amount == 15023);
        $this->assertTrue($result->currency == 'RUB');

        $this->expectException(CurrencyNotFound::class);

        $moneyService->of(150, 'XYZ');
    }

    /** @test */
    public function of_minor_method()
    {
        $moneyService = new MoneyService([
            'storage' => FakeCurrencyStorage::class,
            'formatter' => FakeMoneyFormatter::class,
            'serializer' => FakeMoneySerializer::class
        ]);

        $result = $moneyService->ofMinor(15023, 'RUB');

        $this->assertTrue($result->amount == 15023);
        $this->assertTrue($result->currency == 'RUB');

        $this->expectException(CurrencyNotFound::class);

        $moneyService->of(150, 'XYZ');
    }
}

# Some other fake dependencies

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