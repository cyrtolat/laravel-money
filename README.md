# Laravel Money

[![Stable Version](https://img.shields.io/github/v/release/cyrtolat/laravel-money?label=stable&style=flat-square)](https://packagist.org/packages/cyrtolat/laravel-money)
[![License](https://img.shields.io/github/license/cyrtolat/laravel-money?style=flat-square)](https://packagist.org/packages/cyrtolat/laravel-money)
[![For Laravel](https://img.shields.io/badge/Laravel-8.x%20%7C%209.x-orange.svg?style=flat-square)](https://img.shields.io/badge/Laravel-8.x%20%7C%209.x-orange.svg?style=flat-square)

## Contents
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#Usage)
- [License](#license)

## Installation

## Configuration

## Usage

```php
The docs in development.. 

use \Cyrtolat\Money\Facades\Money;

// Создание экземпляров
$money = Money::of(150.23, 'RUB'); // 150.23 RUB
$money = Money::ofMinor(15023, 'RUB'); // 150.23 RUB

$currency = Money::getCurrencyBy('RUB');
$money = Money::of(150.23, $currency);
$money = Money::ofMinor(15023, $currency);

// Сериализация и рендинг. См. конфигурацию
$money->toArray(); 
$money->toJson();
$money->render();

// Базовая математика
$money = $money->plus($money);
$money = $money->minus($money);
$money = $money->multiplyBy(5);
$money = $money->divideBy(2);
$money = $money->round();

// Сравнение экземпляров
$money->hasSameCurrency($money); // Сравнивает только по валюте
$money->hasSameAmount($money); // Сравнивает только по сумме
$money->equals($money); // Проверяет эквивалентность
$money->gt($money); // >
$money->gte($money); // >=
$money->lt($money); // <
$money->lte($money); // <=


```

## License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.
