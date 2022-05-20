# Laravel Money

## Installation

Run the following command from you terminal:

```bash
composer require cyrtolat/laravel-money
```

Then publish the config file with this command:

```bash
php artisan vendor:publish --provider="Cyrtolat\Money\MoneyServiceProvider"
```

## Usage

Money is an immutable class. All operations on a Money return a new instance.

### Creating a Money

To create an instance of Money, call the ```ofMinor()``` or ```ofMajor()``` factory methods:

```php
use Cyrtolat\Money\Money;

$money = Money::ofMinor(150, "RUB"); // 1,50 RUB
$money = Money::ofMajor(150, "RUB"); // 150,00 RUB
$money = Money::ofMajor(150.23, "RUB"); // 150,23 RUB
```

If, when creating an instance, a decimal value is called by the ```ofMajor()``` method, the number of decimal places of which exceeds that of the currency, then the value will be rounded.

```php
use Cyrtolat\Money\Money;

$money = Money::ofMajor(150.235, "RUB"); // 150,24 RUB
```

If desired, you can give the rounding mode with the third parameter.

```php
use Cyrtolat\Money\Money;

Money::ofMajor(150.235, "RUB", PHP_ROUND_HALF_DOWN); // 150,23 RUB
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

Several arguments can be given to the ```plus()``` and ```minus()``` methods:

```php
use Cyrtolat\Money\Money;

$money = Money::ofMajor(150, "RUB");

$monies = [
  Money::ofMajor(200, "RUB"),
  Money::ofMajor(100, "RUB"),
  Money::ofMajor(50, "RUB")
];

echo $money->plus(...$monies); // 500,00 RUB
```

In the multiplication and division methods, the rounding mode can be given by the third parameter:

```php
use Cyrtolat\Money\Money;

$money = Money::ofMajor(100, "RUB");

echo $money->multiplyBy(5.00015); // 500,02 RUB
echo $money->multiplyBy(5.00015, PHP_ROUND_HALF_DOWN); // 500,01 RUB
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

- ```isZero()``` Returns the result of a comparison an amount with zero
- ```isPositive()``` Returns true if an amount is greater than zero
- ```isNegative()``` Returns true if an amount is less than zero
- ```hasSameCurrency() ``` Returns true if monies has the same currency

The next methods require that the currencies of the Money be the same

- ```equals() ``` Returns true if this instance is equal to another
- ```gt(Money)``` Returns true if this instance is greater than a given
- ```gte(Money)``` Returns true if this instance is greater than or equal to a given
- ```lt(Money)``` Returns true if this instance is less than a given
- ```lte(Money)``` Returns true if this instance is less than or equal to a given

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

### Formatting

To format your Money, you need to call the ```format()``` method:

```php
use Cyrtolat\Money\Money;

$money = Money::ofMajor(150, "RUB");

echo $money->format(); // 1,50 RUB
```

This method formats Money according to Formatters - special formatting classes. They are responsible for exactly how the Money will be displayed. By default, a class from the configuration is used for formatting. The package includes several formatters:

```php
use Cyrtolat\Money\Money;
use Cyrtolat\Money\Formatters\MoneyDefaultFormatter;
use Cyrtolat\Money\Formatters\MoneyDecimalFormatter;
use Cyrtolat\Money\Formatters\MoneyRoundedFormatter;
use Cyrtolat\Money\Formatters\MoneyLocalizedFormatter;

$money = Money::ofMajor(150.55, "RUB");

$defaultFormatter = new MoneyDefaultFormatter();
$decimalFormatter = new MoneyDecimalFormatter();
$roundedFormatter = new MoneyRoundedFormatter();
$localizedFormatter = new MoneyLocalizedFormatter();

echo $money->format($defaultFormatter);   // 150,55 RUB
echo $money->format($decimalFormatter);   // 150,55
echo $money->format($roundedFormatter);   // 151 RUB
echo $money->format($localizedFormatter); // 150,00 ₽
```

You can create your own Formatter. It must implement class ```Cyrtolat\Money\Contracts\MoneyFormatterContract``` of this package.

### Serialization

The Serializer classes are responsible for how laravel will convert Money to array and JSON. For example, if you want Money values to be converted to minor unit in your API Resources, you should specify the appropriate serializer in the config:

configs\money.php:

```php
/*
 |--------------------------------------------------------------------------
 | Money Serializer class
 |--------------------------------------------------------------------------
 |
 | The money serializer class determine how the instance of Money class will
 | be converted to array and json. This is necessary, for example, in the
 | API Resources classes. Specify here the class of one of the ready-made
 | serializers or write your own. But remember that a custom serializer
 | must implement MoneySerializerContract of this package.
 |
 */
     
'serializer' => \Cyrtolat\Money\Serializers\MoneyIntegerSerializer::class,
```

```php
use Cyrtolat\Money\Money;

Money::ofMajor(150.23, "RUB")->toArray(); // ["amount" => 15023, ...]
```

or with a decimal serializer:

```php
'serializer' => \Cyrtolat\Money\Serializers\MoneyDecimalSerializer::class,
```

```php
use Cyrtolat\Money\Money;

Money::ofMajor(150.23, "RUB")->toArray(); // ["amount" => 150.23, ...]
```

You can also create your own serilizers. They should inherit ```Cyrtolat\Money\Contracts\MoneySerializerContract```.

### Casts

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
