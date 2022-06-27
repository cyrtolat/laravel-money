# Laravel Money

[![Latest Version on Packagist](https://img.shields.io/packagist/v/cyrtolat/laravel-money?style=flat-square)](https://packagist.org/packages/cyrtolat/laravel-money)
[![License](https://img.shields.io/github/license/cyrtolat/laravel-money?style=flat-square)](https://packagist.org/packages/cyrtolat/laravel-money)

## Contents
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#Usage)
    - [Creating a money](#creating-a-money)
    - [Basic operations](#basic-operations)
    - [Database queries](#database-querues)
    - [Custom currency](#custom-currency)
    - [Serialization](#serialization)
    - [Formatting](#formatting)
    - [Casts](#casts)
- [Testing](#testing)
- [Changelog](#changelog)
- [License](#license)

## Installation

Run the following command from you terminal:

```bash
composer require cyrtolat/laravel-money
```

## Configuration

Package configuration starts with publishing the configuration file. You can do this by running the following command in the terminal:

```bash
php artisan vendor:publish --provider="Cyrtolat\Money\MoneyServiceProvider"
```

After executing the command, `money.php ` file will be added to your `config` directory. Then you need to configure the parameters. This is a very important stage, as some settings, if selected incorrectly, can break your application.

The current version of the package has 3 configuration options:

- `locale` &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- setting of a Money localization;
- `serializer` - setting of a Money serialization style;
- `formatter`  &nbsp;&nbsp;- setting of a Money formatting style.

**Locale**

```php
'locale' => config('app.locale', 'en_US')
```

The first parameter "locale" is responsible for the localization of the currency. In particular, it is used when formatting Money into a string by some Formatters classes. As you can see, by default, "locale" refers to the localization setting of your laravel application, but if desired, it can be set to any.

**Serializer**

```php
'serializer' => \Cyrtolat\Money\Serializers\MoneyIntegerSerializer::class
```

A serializer is an entity responsible for serializing instances of Money into an array and JSON. This setting contains a class that will convert your Money by default. Read more about serializers in the [Serialization](#serialization) chapter.

**Formatter**

```php
'formatter' => \Cyrtolat\Money\Formatters\MoneyDecimalFormatter::class
```

Formatter is an entity responsible for converting Money into a string. This setting contains a formatter that formats Money instances by default. Read more about formatters in the [Formatting](#formatting) chapter.

## Usage

Money is an immutable class. All operations on a Money return a new instance. Remember this and don't be afraid to work with your Money objects.

### Creating a money

To create an instance of Money call the `of()` or the `ofMinor()` factory methods:

```php
use Cyrtolat\Money\Money;

$money = Money::of(150, "RUB"); // 150,00 RUB
$money = Money::of(150.23, "RUB"); // 150,23 RUB
$money = Money::ofMinor(150, "RUB"); // 1,50 RUB
```

>**_Note:_** The `ofMinor()` method gets only an integer value.

If a decimal value is called when creating an instance using the `of()` method, the number of decimal places in which exceeds the number of decimal places in the currency, the value will be rounded.
If necessary, you can set the rounding mode using the third parameter.

```php
use Cyrtolat\Money\Money;

echo Money::of(150.235, "RUB"); // 150,24 RUB
echo Money::of(150.235, "RUB", PHP_ROUND_HALF_DOWN); // 150,23 RUB
```

### Basic operations

```php
use Cyrtolat\Money\Money;

$money = Money::of(150, "RUB");

echo $money->plus(Money::of(200, "RUB")); // 350,00 RUB
echo $money->minus(Money::of(500, "RUB")); // 100,00 RUB
echo $money->multiplyBy(5); // 500,00 RUB
echo $money->divideBy(5); // 3,00 RUB
```

The `plus()` and `minus()` methods can be given several arguments:

```php
use Cyrtolat\Money\Money;

$money = Money::of(500, "RUB");

$monies = [
  Money::of(50, "RUB"),
  Money::of(25, "RUB"),
  Money::of(10, "RUB")
];

echo $money->plus(...$monies); // 585,00 RUB
echo $money->minus(...$monies); // 415,00 RUB
```

In the `multiplyBy()` and `divideBy()` methods, the rounding mode can be set by the third parameter:

```php
use Cyrtolat\Money\Money;

$money = Money::of(100, "RUB");

echo $money->multiplyBy(5.00015); // 500,02 RUB
echo $money->multiplyBy(5.00015, PHP_ROUND_HALF_DOWN); // 500,01 RUB

echo $money->divideBy(5.00015); // 20,00 RUB
echo $money->divideBy(5.00015, PHP_ROUND_HALF_DOWN); // 19,99 RUB
```

Rounding can also be called outside the context of division and multiplication:

```php
use Cyrtolat\Money\Money;

$money = Money::of(100.5, "RUB");

echo $money->round(); // 101,00 RUB
echo $money->round(0, PHP_ROUND_HALF_DOWN); // 100,00 RUB
```

>**_Note:_** It is important that all mathematical actions require that the currency of monies be the same. Otherwise, an exception will be thrown.

If you need to compare instances of Money with each other, then you can do it in one of the following ways:

- `isZero()` Returns true if an amount is zero
- `isPositive()` Returns true if an amount is greater than zero
- `isNegative()` Returns true if an amount is less than zero
- `hasSameCurrency() ` Returns true if monies has the same currency

The next methods require that the currencies of the Money be the same

- `equals()`  Returns true if this instance is equal to another
- `gt()` Returns true if this instance is greater than a given
- `gte()` Returns true if this instance is greater than or equal to a given
- `lt()` Returns true if this instance is less than a given
- `lte()` Returns true if this instance is less than or equal to a given

```php
use Cyrtolat\Money\Money;

$money = Money::of(100, "RUB");

echo $money->equals(Money::of(100, "RUB")); // true
echo $money->equals(Money::of(200, "RUB")); // false

echo $money->gt(Money::of(200, "RUB")); // false
echo $money->lt(Money::of(200, "RUB")); // true
```

### Database queries

If you need to search a column with cast, you can use scope `whereMoney()` that is a wrapper over the standard `where()` method of the model.
```php
use Cyrtolat\Money\Money;
use App\Models\Payment;

$money = Money::of(150, 'RUB');
$payment = Payment::whereMoney('sum', '=', $money)->get();
$payment = Payment::whereMoney('sum', '<', $money)->get();
$payment = Payment::whereMoney('sum', '>', $money)->get();

// ...
```

Its main property is that it transforms the given Money object according to the model cast. It is added to the model with the `HasMoney` trait. I advise you not to use this method outside of the model, but to wrap it in scope.

```php 
use Illuminate\Database\Eloquent\Model;
use Cyrtolat\Money\Casts\MoneyDecimalCast;
use Cyrtolat\Money\HasMoney;
use Cyrtolat\Money\Money;

class Payment extends Model
{
    use HasMoney;
    
    /** ... */
    protected $casts = [
        'sum' => MoneyDecimalCast::class . ':RUB',
    ];
    
    /** ... */
    public function scopeWhereSum(Builder $query, Money $money): Builder
    {
        return $query->whereMoney('sum', '=', $money);
    }
}
```

### Custom currency

Some applications require custom currencies. This package supports the addition of such. To do this, you need to create an instance of the Сurrency and register it. Then it will be available in the currency factory. Write this in your service provider:

```php
use Cyrtolat\Money\Money;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Providers\CurrencyProvider;

$provider = CurrencyProvider::getInstance();
$currency = new Currency(
  "MCC",                // alphabetic code
  "My Custom Currency", // currency name
  "0",                  // numeric code
  2                     // fraction digits
);
$provider->registerCurrency($currency);

echo Money::ofMinor(150, "MCC"); // 1,50 MCC
```

>**_Note:_** If the currency doesn't have a numeric code, then specify it as zero.


### Serialization

The Money class implements Laravel `Arrayable` and `Jsonable` contracts, and therefore the money attributes contained in the models do not need to be processed wherever the transformation takes place. The package will do it itself. You only need to choose one of the provided serializers or write your own.

According to the implementation of contracts, serialization to array and to JSON is called by the methods `toArray()` and `toJSON`:

```php
use Cyrtolat\Money\Money;

Money::of(150.23, "RUB")->toArray(); // (array) [...]
Money::of(150.23, "RUB")->toJson(); // (string) "{...}"
```

Internally, they refer to the Serializer class specified in the config, so once you set the class, you specify the serialization style for all the Money objects of your application.

Initially, the package contains two serializer classes:

name | class | example
:----:|:-------:|:-------:
Integer | `Cyrtolat\Money\Serializers\MoneyIntegerSerializer` | `{"amount":15055,"currency":"RUB"}`
Decimal | `Cyrtolat\Money\Serializers\MoneyDecimalSerializer` | `{"amount":"150.55","currency":"RUB"}`

You can also create your own serilizers. It should implement the following interface of this package:

```php
namespace Cyrtolat\Money\Contracts;

use Cyrtolat\Money\Money;

/**
 * Serializes Money objects.
 */
interface MoneySerializerContract
{
    /**
     * Returns an array representation of an instance of Money class.
     *
     * @param Money $money The Money class instance.
     * @param array $params The array of params to formatting.
     * @return array
     */
    public function toArray(Money $money, array $params = []): array;
}
```

### Formatting

To format your Money you need to call the method `format()`, which is also implicitly called via the magic method `__toString()`

```php
use Cyrtolat\Money\Money;

$money = Money::of(150, "RUB");

echo $money->format(); // 150 RUB
echo $money; // 150 RUB
```

It formats money by default formatter that is set in the configs. If you need to format money in another style, then you need to create an instance of the formatter and give it Money object:

```php
use Cyrtolat\Money\Money;
use Cyrtolat\Money\Formatters\MoneyLocalizedFormatter;

$money = Money::of(150.55, "RUB");

$localizedFormatter = new MoneyLocalizedFormatter();

echo $localizedFormatter->format($money); // 150,55 ₽
```

Initially, the package includes 4 formatters:

name | class | example
:----:|:-------:|:-------:
Decimal | `Cyrtolat\Money\Formatters\MoneyDecimalFormatter` | 150,55 RUB
Numeric | `Cyrtolat\Money\Formatters\MoneyNumericFormatter` | 150,55
Rounded | `Cyrtolat\Money\Formatters\MoneyRoundedFormatter` | 151 RUB
Localized | `Cyrtolat\Money\Formatters\MoneyLocalizedFormatter` | 150,55 ₽

You can create your own formatter. It should implement the following interface of this package:

```php
namespace Cyrtolat\Money\Contracts;

use Cyrtolat\Money\Money;

/**
 * Formatters Money objects.
 */
interface MoneyFormatterContract
{
    /**
     * Formats a Money object as a string.
     *
     * @param Money $money The instance of Money class.
     * @param array $params The array of params to formatting.
     * @return string
     */
    public function format(Money $money, array $params = []): string;
}
```

### Casts

The package contains several casts:

name | class | example
:----:|:-------:|:-------:
Integer | `Cyrtolat\Money\Casts\MoneyIntegerCast` | 15055
Decimal | `Cyrtolat\Money\Casts\MoneyDecimalCast` | 150.55


When using them, it is necessary to specify the currency or attribute containing it:

```php
use Cyrtolat\Money\Casts\MoneyDecimalCast;
use Cyrtolat\Money\Casts\MoneyIntegerCast;

protected $casts = [
    // this cast writes a minor amount in database as an integer
    'money' => MoneyIntegerCast::class . ':RUB', 
    // this cast writes a major amount in database as a decimal
    'money' => MoneyDecimalCast::class . ':USD',
    // this cast using the currency code that defined in the model attribute 
    'money' => MoneyDecimalCast::class . ':attribute_name'
];
```

When we pass the model attribute holding the currency, such attribute is updated as well when setting money:

```php
use Cyrtolat\Money\Money;

$model->money = Money::of(150.23, "RUB");
echo $model->money; // 150.23 RUB
echo $model->currency; // RUB

$model->money = Money::of(60.46, "USD");
echo $model->money; // 60.46 USD
echo $model->currency; // USD
```

## Testing

Phpunit is used to test this library. To start testing run the command:

```bash
$ composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.
