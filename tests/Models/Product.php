<?php

namespace Cyrtolat\Money\Tests\Models;

use Cyrtolat\Money\Casts\AssignableMoneyCast;
use Cyrtolat\Money\Casts\ImmutableMoneyCast;
use Illuminate\Database\Eloquent\Model;
use Cyrtolat\Money\HasMoney;

class Product extends Model
{
    use HasMoney;

    protected $casts = [
        'decimal_price_rub' => ImmutableMoneyCast::class . ':RUB,decimal',
        'integer_price_rub' => ImmutableMoneyCast::class . ':RUB,integer',
        'decimal_price' => AssignableMoneyCast::class . ':currency,decimal',
        'integer_price' => AssignableMoneyCast::class . ':currency,integer',
    ];
}