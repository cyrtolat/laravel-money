<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\Money;
use Cyrtolat\Money\Services\MoneyService;
use Cyrtolat\Money\Exceptions\CurrencyMismatch;
use Cyrtolat\Money\Tests\Entities\FakeCurrencyStorage;
use Cyrtolat\Money\Tests\Entities\FakeMoneyFormatter;
use Cyrtolat\Money\Tests\Entities\FakeMoneySerializer;
use Cyrtolat\Money\Tests\Models\Product;
use Illuminate\Support\Facades\DB;

class CasterTest extends TestCase
{
    protected MoneyService $service;

    protected function setUp(): void
    {
        $this->service = new MoneyService([
            'storage' => FakeCurrencyStorage::class,
            'formatter' => FakeMoneyFormatter::class,
            'serializer' => FakeMoneySerializer::class
        ]);

        parent::setUp();
    }

    /** @test */
    public function getting_money_value()
    {
        DB::table('products')->insert([
            'decimal_price_rub' => 1234.56,
            'integer_price_rub' => 123456,
            'decimal_price' => 1234.56,
            'integer_price' => 123456,
            'currency' => 'RUB'
        ]);

        $money = $this->service->of(1234.56, 'RUB');
        $product = Product::orderByDesc('id')->first();

        $this->assertTrue($money->equals($product->decimal_price_rub));
        $this->assertTrue($money->equals($product->integer_price_rub));
        $this->assertTrue($money->equals($product->decimal_price));
        $this->assertTrue($money->equals($product->integer_price));
    }

    /** @test */
    public function getting_null_value()
    {
        DB::table('products')->insert([
            'decimal_price_rub' => null,
            'integer_price_rub' => null,
            'decimal_price' => null,
            'integer_price' => null,
            'currency' => null
        ]);

        $product = Product::orderByDesc('id')->first();

        $this->assertNull($product->decimal_price_rub);
        $this->assertNull($product->integer_price_rub);
        $this->assertNull($product->decimal_price);
        $this->assertNull($product->integer_price);
    }

    /** @test */
    public function setting_money_value()
    {
        $money = $this->service->of(1234.56, 'RUB');

        $product = new Product();
        $product->decimal_price_rub = $money;
        $product->integer_price_rub = $money;
        $product->decimal_price = $money;
        $product->integer_price = $money;
        $product->save();

        $result = DB::table('products')->orderBy('id', 'desc')->first();

        $this->assertEquals(1234.56, $result->decimal_price_rub);
        $this->assertEquals(123456, $result->integer_price_rub);
        $this->assertEquals(1234.56, $result->decimal_price);
        $this->assertEquals(123456, $result->integer_price);
    }

    /** @test */
    public function setting_wrong_value()
    {
        $product = new Product();

        try {
            $product->decimal_price_rub = [];
            $this->fail('Exception was not thrown.');
        } catch (\InvalidArgumentException) {
            $this->assertTrue(true);
        }

        try {
            $product->integer_price_rub = true;
            $this->fail('Exception was not thrown.');
        } catch (\InvalidArgumentException) {
            $this->assertTrue(true);
        }

        try {
            $product->decimal_price = 12345;
            $this->fail('Exception was not thrown.');
        } catch (\InvalidArgumentException) {
            $this->assertTrue(true);
        }

        try {
            $product->integer_price = 'Lorem ipsum';
            $this->fail('Exception was not thrown.');
        } catch (\InvalidArgumentException) {
            $this->assertTrue(true);
        }

        # when currency is not like in cast
        try {
            $product->decimal_price_rub = new Money(150, 'USD');
            $this->fail('Exception was not thrown.');
        } catch (CurrencyMismatch) {
            $this->assertTrue(true);
        }
    }

    /** @test */
    public function setting_null_value()
    {
        $product = new Product();
        $product->decimal_price_rub = null;
        $product->integer_price_rub = null;
        $product->decimal_price = null;
        $product->integer_price = null;
        $product->save();

        $result = DB::table('products')->orderBy('id', 'desc')->first();

        $this->assertNull($result->decimal_price_rub);
        $this->assertNull($result->integer_price_rub);
        $this->assertNull($result->decimal_price);
        $this->assertNull($result->integer_price);
    }
}