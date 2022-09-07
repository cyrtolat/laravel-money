<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\Exceptions\CurrencyMismatch;
use Cyrtolat\Money\Money;
use Cyrtolat\Money\Tests\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class TraitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function where_money_scope()
    {
        DB::table('products')->insert(['decimal_price_rub' => 0.00]);   // 0.00 RUB
        DB::table('products')->insert(['decimal_price_rub' => 100.23]); // 100.23 RUB
        DB::table('products')->insert(['decimal_price_rub' => 200.23]); // 200.23 RUB
        DB::table('products')->insert(['decimal_price_rub' => 300.23]); // 300.23 RUB

        $result = Product::whereMoney('decimal_price_rub', '>', new Money(20000, 'RUB'))->count();
        $this->assertEquals(2, $result);

        $result = Product::whereMoney('decimal_price_rub', '=', new Money(20023, 'RUB'))->count();
        $this->assertEquals(1, $result);

        $result = Product::whereMoney('decimal_price_rub', '=', new Money(4986, 'RUB'))->count();
        $this->assertEquals(0, $result);

        $result = Product::whereMoney('decimal_price_rub', '!=', new Money(30023, 'RUB'))->count();
        $this->assertEquals(3, $result);

        $result = Product::whereMoney('decimal_price_rub', '>=', new Money(10000, 'RUB'))
            ->whereMoney('decimal_price_rub', '<=', new Money(30000, 'RUB'))->count();
        $this->assertEquals(2, $result);

        # invalid currency
        $this->expectException(CurrencyMismatch::class);
        Product::whereMoney('decimal_price_rub', '=', new Money(20023, 'USD'))->count();
    }
}