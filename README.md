# Laravel Money

Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.

## Installation

Run the following command from you terminal:

```bash
composer require cyrtolat/laravel-money
```

## Configuration

Like most packages for large frameworks, this package allows you to customize some behavior parameters according to your needs. To better understand why they are needed, please read this section. This is important because some settings may conflict with your application.

### Publish command

Package configuration starts with publishing the configuration file. You can do this by running the following command in the terminal:

```bash
php artisan vendor:publish --provider="Cyrtolat\Money\MoneyServiceProvider"
```

This adds a `money.php` file to your `config/` directory.

### Default settings

The current version of the package has 3 default parameters:

- `locale` &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- setting of a Money localization;
- `serializer` - setting of a Money serialization;
- `formatter`  &nbsp;&nbsp;- setting of a Money default formatting.

**Locale**

```php
'locale' => config('app.locale', 'en_US')
```

The first parameter "locale" is responsible for the localization of the currency. In particular, it is used when formatting Money into a string by some Formatters classes. As you can see, by default, "locale" refers to the localization setting of your laravel application, but if desired, it can be set to any.

**Serializer**

```php
'serializer' => \Cyrtolat\Money\Serializers\MoneyIntegerSerializer::class
```

A serializer is an object responsible for serializing instances of Money into an array and JSON. This setting contains a class that will convert your Money by default. Read more about serializers in the serialization chapter.

**Formatter**

```php
'formatter' => \Cyrtolat\Money\Formatters\MoneyDefaultFormatter::class
```

Formatters are the classes responsible for converting Money into a string. This setting contains a formatter that formats Money instances by default. Read more about formatters in the formatting chapter.

## Usage

Money is an immutable class. All operations on a Money return a new instance.

### Creating a Money

To create an instance of Money call the `ofMinor()` or the `ofMajor()` factory methods:

```php
use Cyrtolat\Money\Money;

$money = Money::ofMinor(150, "RUB"); // 1,50 RUB
$money = Money::ofMajor(150, "RUB"); // 150,00 RUB
$money = Money::ofMajor(150.23, "RUB"); // 150,23 RUB
```

If a decimal value is called when creating an instance using the `ofMajor()` method, the number of decimal places in which exceeds the number of decimal places in the currency, the value will be rounded.
If necessary, you can set the rounding mode using the third parameter.

```php
use Cyrtolat\Money\Money;

echo Money::ofMajor(150.235, "RUB"); // 150,24 RUB
echo Money::ofMajor(150.235, "RUB", PHP_ROUND_HALF_DOWN); // 150,23 RUB
```

### Basic operations

```php
use Cyrtolat\Money\Money;

$money = Money::ofMajor(150, "RUB");

echo $money->plus(Money::ofMajor(200, "RUB")); // 350,00 RUB
echo $money->minus(Money::ofMajor(500, "RUB")); // 100,00 RUB
echo $money->multiplyBy(5); // 500,00 RUB
echo $money->divideBy(5); // 3,00 RUB
```

The `plus()` and `minus()` methods can be given several arguments:

```php
use Cyrtolat\Money\Money;

$money = Money::ofMajor(500, "RUB");

$monies = [
  Money::ofMajor(50, "RUB"),
  Money::ofMajor(25, "RUB"),
  Money::ofMajor(10, "RUB")
];

echo $money->plus(...$monies); // 585,00 RUB
echo $money->minus(...$monies); // 415,00 RUB
```

In the `multiplyBy()` and `divideBy()` methods, the rounding mode can be set by the third parameter:

```php
use Cyrtolat\Money\Money;

$money = Money::ofMajor(100, "RUB");

echo $money->multiplyBy(5.00015); // 500,02 RUB
echo $money->multiplyBy(5.00015, PHP_ROUND_HALF_DOWN); // 500,01 RUB

echo $money->divideBy(5.00015); // 20,00 RUB
echo $money->divideBy(5.00015, PHP_ROUND_HALF_DOWN); // 19,99 RUB
```

Rounding can also be called outside the context of division and multiplication:

```php
use Cyrtolat\Money\Money;

$money = Money::ofMajor(100.5, "RUB");

echo $money->round(); // 101,00 RUB
echo $money->round(0, PHP_ROUND_HALF_DOWN); // 100,00 RUB
```

>**Note:** It is important that all mathematical actions require that the currency of monies be the same. Otherwise, an exception will be thrown.

If you need to compare instances of Money with each other, then you can do it in one of the following ways:

- `isZero()` Returns the result of a comparison an amount with zero
- `isPositive()` Returns true if an amount is greater than zero
- `isNegative()` Returns true if an amount is less than zero
- `hasSameCurrency() ` Returns true if monies has the same currency

The next methods require that the currencies of the Money be the same

- `equals()`  Returns true if this instance is equal to another
- `gt(Money)` Returns true if this instance is greater than a given
- `gte(Money)` Returns true if this instance is greater than or equal to a given
- `lt(Money)` Returns true if this instance is less than a given
- `lte(Money)` Returns true if this instance is less than or equal to a given

```php
use Cyrtolat\Money\Money;

$money = Money::ofMajor(100, "RUB");

echo $money->equals(Money::ofMajor(100, "RUB")); // true
echo $money->equals(Money::ofMajor(200, "RUB")); // false

echo $money->gt(Money::ofMajor(200, "RUB")); // false
echo $money->lt(Money::ofMajor(200, "RUB")); // true
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

>**Note:** If the currency doesn't have a numeric code, then specify it as zero.

## Formatting

To format your Money you need to call the method `format()`, which is also implicitly called via the magic method `__toString()`

```php
use Cyrtolat\Money\Money;

$money = Money::ofMajor(150, "RUB");

echo $money->format(); // 1,50 RUB
echo $money; // 1,50 RUB
```

It formats money by default formatter that is set in the configs. If you need to format money in another style, then you need to create an instance of the formatter and give it Money object:

```php
use Cyrtolat\Money\Money;
use Cyrtolat\Money\Formatters\MoneyLocalizedFormatter;

$money = Money::ofMajor(150.55, "RUB");

$localizedFormatter = new MoneyLocalizedFormatter();

echo $localizedFormatter->format($money); // 150,55 ₽
```

Initially, the package includes 4 formatters:

- `Cyrtolat\Money\Formatters\MoneyDefaultFormatter`
- `Cyrtolat\Money\Formatters\MoneyDecimalFormatter`
- `Cyrtolat\Money\Formatters\MoneyRoundedFormatter`
- `Cyrtolat\Money\Formatters\MoneyLocalizedFormatter`

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

## Serialization

The Money class implements Laravel Arrayable and Jsonable contracts, and therefore the money attributes contained in the models do not need to be processed wherever the transformation takes place. The package will do it itself. You only need to choose one of the provided serializers or write your own.

According to the implementation of contracts, serialization to array and to JSON is called by the methods `toArray()` and `toJSON`:

```php
use Cyrtolat\Money\Money;

Money::ofMajor(150.23, "RUB")->toArray(); // (array) [...]
Money::ofMajor(150.23, "RUB")->toJson(); // (string) {...}
```

Internally, they refer to the Serializer class specified in the config, so once you set the class, you specify the serialization style for all the Money objects of your application.

Initially, the package contains two serializer classes:

- `Cyrtolat\Money\Serializers\MoneyIntegerSerializer`
- `Cyrtolat\Money\Serializers\MoneyDecimalSerializer`

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

## Casts

The package contains several casts:
- ```Cyrtolat\Money\Casts\MoneyDecimalCast```
- ```Cyrtolat\Money\Casts\MoneyIntegerCast```

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

$model->money = Money::ofMajor(150.23, "RUB");
echo $model->money; // 150.23 RUB
echo $model->currency; // RUB

$model->money = Money::ofMajor(60.46, "USD");
echo $model->money; // 60.46 USD
echo $model->currency; // USD
```

## Testing

Phpunit is used to test this library. To start testing run the command:

```bash
composer test
```

## Planned

The following updates will be implemented:

- [ ] To add cryptocurrencies by default
- [ ] To add currency exchanger with the ability to write drivers
- [ ] To add validation rules

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [LICENSE](LICENSE.md) for more information.
