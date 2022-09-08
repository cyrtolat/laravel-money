# Laravel Money

[![Stable Version](https://img.shields.io/github/v/release/cyrtolat/laravel-money?label=stable&style=flat-square)](https://packagist.org/packages/cyrtolat/laravel-money)
[![For Laravel](https://img.shields.io/badge/Laravel-8.x%20%7C%209.x-orange.svg?style=flat-square)](https://img.shields.io/badge/Laravel-8.x%20%7C%209.x-orange.svg?style=flat-square)
[![License](https://img.shields.io/github/license/cyrtolat/laravel-money?style=flat-square)](https://packagist.org/packages/cyrtolat/laravel-money)

The docs and translation in development..

## Preface

Данный пакет предназначен для приложений, в доменной модели которых деньги являются объект-значениями. Его основная задача состоит в том, чтобы избавить разработчика от необходимости адаптировать известные библиотеки денег под архитектуру Ларавель. Этот пакет изначально строится на ней.   

## Contents
- [Preface](#preface)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#Usage)
  - [Money creating](#money-creating)
  - [Math and comparing](#math-and-comparing)
  - [Formatting](#formatting)
  - [Serialization](#serialization)
- [License](#license)

## Installation

Для установки пакета запустите следующую команду в теринале:

```bash
composer require cyrtolat/laravel-money
```

Или вручную обновите `require` блок вашего `composer.json` и выполните команду `composer update`

```json
{
    "require": {
        "cyrtolat/laravel-money": "^2.0"
    }
}
```

## Configuration

Конфигурация пакета начинается с публикации файла с дефолтными настройками. Делается это следующей командой: 

```bash
php artisan vendor:publish --provider="Cyrtolat\Money\Providers\MoneyServiceProvider"
```

После её выполнения, файл `money.php` будет добавлен в папку `/configs` вашего приложения. Открыв его, вы увидите 4 настройки. Подробно о них:

### Money Locale

```php
'locale' => 'en_US'
```

Параметр `locale` - это языковой тег BCP 47. Он определяет стиль форматирования денежных значений в строки в соответствии с выбранной локализацией и используется внутри объектов Intl.NumberFormat.

### Currency Storage

```php
'storage' => \Cyrtolat\Money\Storages\DefaultCurrencyStorage::class
```

Параметр `storage` хранит в себе класс-реализацию интерфейса `Cyrtolat\Contracts\CurrencyStorage`. Это репозиторий, которых хранит в себе все доступные в приложении валюты. По умолчанию определено дефолтное хранилище, в котором лежат данные ISO валют и некоторых известных криптовалют. В большинстве случаев его будет достаточно, но если Вам требуется работать с валютой, которой нет в этом хранилище, то вы можете реализовать своё.

### Currency Serializer

```php
'serializer' => \Cyrtolat\Money\Serializers\MajorMoneySerializer::class
```

Аналогично предыдущему параметру, `serializer` хранит в себе класс-реализацию интерфейса `Cyrtolat\Contracts\MoneySerializer`. Этот класс отвечает за то каким образом Ларавель будет преобразовывать ваши объекты Money в массивы и строки JSON. "Из коробки" доступно несколько сериализаторов. Подробнее о них в [этом](#serialization) разделе.

### Currency Formatter

```php
'formatter' => \Cyrtolat\Money\Formatters\DecimalMoneyFormatter::class
```

Последний параметр `formatter` хранит в себе класс-реализацию интерфейса `Cyrtolat\Contracts\MoneyFormatter`. Этот класс отвечает за рендеринг объектов Money в строки. Изначально доступно несколько форматторов. Подробнее о них Подробнее о них в [здесь](#formatting).

## Usage

### Money Creating

Создание экземпляров Money предлагается через фасад сервиса `\Cyrtolat\Money\Service\MoneyService`. Выглядит следующим образом:

```php
use \Cyrtolat\Money\Facades\Money;

# указание значения в "минорном" и "мажорном" стилях
$money = Money::of(150.23, 'RUB'); // 150.23 RUB
$money = Money::ofMinor(15023, 'RUB'); // 150.23 RUB

# также можно передавать и объект Currency вместо кода
$currency = Money::getCurrencyOf('RUB');

$money = Money::of(150.23, $currency);
$money = Money::ofMinor(15023, $currency);
```

>Помните про хранилище валют? Если попытаться через сервис создать деньги с валютой, которой нет в хранилище, то будет ошибка.

### Math and comparing

Объекты Money между собой можно сравнивать, складывать и вычитать. Как это делается показано далее:

```php
use \Cyrtolat\Money\Facades\Money;

$money_1 = Money::of(150.23, 'RUB'); // 150.23 RUB
$money_2 = Money::of(320.88, 'RUB'); // 320.88 RUB

$money = $money_1->plus($money_2); // $money_1 + $money_2
$money = $money_1->minus($money_2); // $money_1 - $money_2
$money = $money_1->multiplyBy(2.3); // $money_1 * 2.3
$money = $money_1->divideBy(4); // $money_1 / 4
$money = $money_1->round(); // 150.00 RUB

$bool = $money_1->gt($money_2); // $money_1 > $money_2
$bool = $money_1->gte($money_2); // $money_1 >= $money_2
$bool = $money_1->lt($money_2); // $money_1 < $money_2
$bool = $money_1->lte($money_2); // $money_1 <= $money_2
$bool = $money_1->equals($money_2); // $money_1 == $money_2

$bool = $money_1->hasSameAmount($money_2); // false
$bool = $money_1->hasSameCurrency($money_2); // true
```

Объекты денег иммутабельны. Все операции возвращают новый экземпляр. Также не забывайте, что нужно нельзя складывать, вычитать, делить и умножать объекты денег с разными валютами. Это же касается и операций сравнения. Лишь последние два метода не выкинут исключение, если вы передадите в них деньги с отличной от исходного объекта валютой.

### Formatting

Как уже было сказано, за форматирование денег отвечает класс форматтера. Единожды выставив его в конфигах, Вам больше не нужно заботиться о логике форматирования. Пакет сделает это за Вас. Привести объект Money в строчный тип можно следующим образом:

```php
use \Cyrtolat\Money\Facades\Money;

$money = Money::of(150.23, 'RUB');

# I have: 150.23 RUB
echo "I have: " . $money->render();
echo "I have: " . $money;
```

"Из коробки" доступно несколько форматтеров.

форматтер | пример
:-------:|:-------:
`Cyrtolat\Money\Formatters\DecimalMoneyFormatter` | 150.23 RUB
`Cyrtolat\Money\Formatters\LocalizedMoneyFormatter` | 150.23 ₽

### Serialization

Сериализация денег - одна из наиболее важных функций этого пакета. 

## License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.
