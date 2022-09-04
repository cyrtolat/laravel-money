# Laravel Money

[![Latest Version on Packagist](https://img.shields.io/packagist/v/cyrtolat/laravel-money?style=flat-square)](https://packagist.org/packages/cyrtolat/laravel-money)
[![License](https://img.shields.io/github/license/cyrtolat/laravel-money?style=flat-square)](https://packagist.org/packages/cyrtolat/laravel-money)

## Contents
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#Usage)
- [Changelog](#changelog)
- [License](#license)

## Installation

## Configuration

## Usage

```php

use \Cyrtolat\Money\Facades\Money::class;

// Создание экземпляров
$money = Money::ofMajor(150.23, 'RUB'); // 150.23 RUB
$money = Money::ofMinor(15023, 'RUB'); // 150.23 RUB

$currency = Money::getCurrencyBy('RUB');
$money = Money::ofMajor(150.23, $currency);
$money = Money::ofMinor(15023, $currency);

// Сериализация и рендинг. См. конфигурацию
$money->toArray(); 
$money->toJson();
$money->render();

// Базовая математика
$money = $money->plus($money, $money, $money);
$money = $money->minus($money, $money, $money);
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

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.
