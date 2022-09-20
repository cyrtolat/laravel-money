# Laravel Money

[![Stable Version](https://img.shields.io/github/v/release/cyrtolat/laravel-money?label=stable&style=flat-square)](https://packagist.org/packages/cyrtolat/laravel-money)
[![For Laravel](https://img.shields.io/badge/Laravel-8.x%20%7C%209.x-orange.svg?style=flat-square)](https://img.shields.io/badge/Laravel-8.x%20%7C%209.x-orange.svg?style=flat-square)
[![License](https://img.shields.io/github/license/cyrtolat/laravel-money?style=flat-square)](https://packagist.org/packages/cyrtolat/laravel-money)

The docs and translation in development..

[comment]: <> (## Preface)

[comment]: <> (Данный пакет предназначен для приложений, в доменной модели которых деньги являются объект-значениями. Его основная задача состоит в том, чтобы избавить разработчика от необходимости адаптировать известные библиотеки денег под архитектуру Ларавель. Этот пакет изначально строится на ней.   )

## Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#Usage)
  - [Basic](#basic)
  - [Helpers](#helpers)
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

[comment]: <> (### Money Locale)

[comment]: <> (```php)

[comment]: <> ('locale' => 'en_US')

[comment]: <> (```)

[comment]: <> (Параметр `locale` - это языковой тег BCP 47. Он определяет стиль форматирования денежных значений в строки в соответствии с выбранной локализацией и используется внутри объектов Intl.NumberFormat.)

[comment]: <> (### Currency Storage)

[comment]: <> (```php)

[comment]: <> ('storage' => \Cyrtolat\Money\Storages\IsoCurrencyStorage::class)

[comment]: <> (```)

[comment]: <> (Параметр `storage` хранит в себе класс-реализацию интерфейса `Cyrtolat\Contracts\CurrencyStorage`. Это репозиторий, которых хранит в себе все доступные в приложении валюты. По умолчанию определено дефолтное хранилище, в котором лежат данные ISO валют и некоторых известных криптовалют. В большинстве случаев его будет достаточно, но если Вам требуется работать с валютой, которой нет в этом хранилище, то вы можете реализовать своё.)

[comment]: <> (### Currency Serializer)

[comment]: <> (```php)

[comment]: <> ('serializer' => \Cyrtolat\Money\Serializers\MajorMoneySerializer::class)

[comment]: <> (```)

[comment]: <> (Аналогично предыдущему параметру, `serializer` хранит в себе класс-реализацию интерфейса `Cyrtolat\Contracts\MoneySerializer`. Этот класс отвечает за то каким образом Ларавель будет преобразовывать ваши объекты Money в массивы и строки JSON. "Из коробки" доступно несколько сериализаторов. Подробнее о них в [этом]&#40;#serialization&#41; разделе.)

[comment]: <> (### Currency Formatter)

[comment]: <> (```php)

[comment]: <> ('formatter' => \Cyrtolat\Money\Formatters\DecimalMoneyFormatter::class)

[comment]: <> (```)

[comment]: <> (Последний параметр `formatter` хранит в себе класс-реализацию интерфейса `Cyrtolat\Contracts\MoneyFormatter`. Этот класс отвечает за рендеринг объектов Money в строки. Изначально доступно несколько форматторов. Подробнее о них Подробнее о них в [здесь]&#40;#formatting&#41;.)

[comment]: <> (## Usage)

[comment]: <> (### Money Creating)

[comment]: <> (Создание экземпляров Money предлагается через фасад сервиса `\Cyrtolat\Money\Service\MoneyService`. Выглядит следующим образом:)

[comment]: <> (```php)

[comment]: <> (use \Cyrtolat\Money\Facades\Money;)

[comment]: <> (# указание значения в "минорном" и "мажорном" стилях)

[comment]: <> ($money = Money::of&#40;150.23, 'RUB'&#41;; // 150.23 RUB)

[comment]: <> ($money = Money::ofMinor&#40;15023, 'RUB'&#41;; // 150.23 RUB)

[comment]: <> (# также можно передавать и объект Currency вместо кода)

[comment]: <> ($currency = Money::getCurrencyOf&#40;'RUB'&#41;;)

[comment]: <> ($money = Money::of&#40;150.23, $currency&#41;;)

[comment]: <> ($money = Money::ofMinor&#40;15023, $currency&#41;;)

[comment]: <> (```)

[comment]: <> (>Помните про хранилище валют? Если попытаться через сервис создать деньги с валютой, которой нет в хранилище, то будет ошибка.)

[comment]: <> (### Math and comparing)

[comment]: <> (Объекты Money между собой можно сравнивать, складывать и вычитать. Как это делается показано далее:)

[comment]: <> (```php)

[comment]: <> (use \Cyrtolat\Money\Facades\Money;)

[comment]: <> ($money_1 = Money::of&#40;150.23, 'RUB'&#41;; // 150.23 RUB)

[comment]: <> ($money_2 = Money::of&#40;320.88, 'RUB'&#41;; // 320.88 RUB)

[comment]: <> ($money = $money_1->plus&#40;$money_2&#41;; // $money_1 + $money_2)

[comment]: <> ($money = $money_1->minus&#40;$money_2&#41;; // $money_1 - $money_2)

[comment]: <> ($money = $money_1->multiplyBy&#40;2.3&#41;; // $money_1 * 2.3)

[comment]: <> ($money = $money_1->divideBy&#40;4&#41;; // $money_1 / 4)

[comment]: <> ($money = $money_1->round&#40;&#41;; // 150.00 RUB)

[comment]: <> ($bool = $money_1->gt&#40;$money_2&#41;; // $money_1 > $money_2)

[comment]: <> ($bool = $money_1->gte&#40;$money_2&#41;; // $money_1 >= $money_2)

[comment]: <> ($bool = $money_1->lt&#40;$money_2&#41;; // $money_1 < $money_2)

[comment]: <> ($bool = $money_1->lte&#40;$money_2&#41;; // $money_1 <= $money_2)

[comment]: <> ($bool = $money_1->equals&#40;$money_2&#41;; // $money_1 == $money_2)

[comment]: <> ($bool = $money_1->hasSameAmount&#40;$money_2&#41;; // false)

[comment]: <> ($bool = $money_1->hasSameCurrency&#40;$money_2&#41;; // true)

[comment]: <> (```)

[comment]: <> (Объекты денег иммутабельны. Все операции возвращают новый экземпляр. Также не забывайте, что нужно нельзя складывать, вычитать, делить и умножать объекты денег с разными валютами. Это же касается и операций сравнения. Лишь последние два метода не выкинут исключение, если вы передадите в них деньги с отличной от исходного объекта валютой.)

[comment]: <> (### Formatting)

[comment]: <> (Как уже было сказано, за форматирование денег отвечает класс форматтера. Единожды выставив его в конфигах, Вам больше не нужно заботиться о логике форматирования. Пакет сделает это за Вас. Привести объект Money в строчный тип можно следующим образом:)

[comment]: <> (```php)

[comment]: <> (use \Cyrtolat\Money\Facades\Money;)

[comment]: <> ($money = Money::of&#40;150.23, 'RUB'&#41;;)

[comment]: <> (# I have: 150.23 RUB)

[comment]: <> (echo "I have: " . $money->render&#40;&#41;;)

[comment]: <> (echo "I have: " . $money;)

[comment]: <> (```)

[comment]: <> ("Из коробки" доступно несколько форматтеров.)

[comment]: <> (форматтер | пример)

[comment]: <> (:-------:|:-------:)

[comment]: <> (`Cyrtolat\Money\Formatters\DecimalMoneyFormatter` | 150.23 RUB)

[comment]: <> (`Cyrtolat\Money\Formatters\LocalizedMoneyFormatter` | 150.23 ₽)

[comment]: <> (### Serialization)

[comment]: <> (Сериализация денег - одна из наиболее важных функций этого пакета. )

## License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.
