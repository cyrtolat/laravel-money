<?php

namespace Cyrtolat\Money;

use Closure;
use JsonSerializable;
use InvalidArgumentException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * @property-read integer $amount
 * @property-read string $currency
 */
class Money implements Arrayable, Jsonable, Renderable, JsonSerializable
{
    /**
     * The monetary amount.
     *
     * An integer value of the number of monetary units.
     * For currencies with non-zero minor units, the value
     * is specified in them.
     *
     * @var integer
     */
    private int $amount;

    /**
     * The monetary currency.
     *
     * An alphabetic code for ISO currencies or any other
     * string for non-ISO currencies that would contain
     * the entity of the currency.
     *
     * @var string
     */
    private string $currency;

    /**
     * Formatter callback.
     *
     * А closure function that formats this Money
     * object into a string from outside this class.
     *
     * @var null|Closure
     */
    private static ?Closure $formatterCallback;

    /**
     * Serializer callback.
     *
     * А closure function that formats this Money
     * object into an array from outside this class.
     *
     * @var null|Closure
     */
    private static ?Closure $serializeCallback;

    /**
     * The class constructor.
     *
     * @param integer $amount The monetary amount
     * @param string $currency The monetary currency
     */
    public function __construct(int $amount, string $currency)
    {
        $this->amount   = $amount;
        $this->currency = $currency;
    }

    /**
     * Implicit getting hidden properties.
     *
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        return property_exists($this, $property)
            ? $this->$property : null;
    }

    /**
     * Implicit conversion of Money to a string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * Sets the formatter callback.
     *
     * @param  Closure  $callback
     */
    public static function setFormatterCallback(Closure $callback): void
    {
        self::$formatterCallback = $callback;
    }

    /**
     * Sets the serializer callback.
     *
     * @param  Closure  $callback
     */
    public static function setSerializeCallback(Closure $callback): void
    {
        self::$serializeCallback = $callback;
    }

    /**
     * Checking another money currency.
     *
     * @param Money $money
     */
    private function validateCurrency(Money $money): void
    {
        if ($this->currency != $money->currency) {
            throw new InvalidArgumentException(
                "Currencies must be identical.");
        }
    }

    /**
     * Returns true if the given Money equal to this.
     *
     * @param Money $money Money instance for comparison
     * @return bool True if amounts and currencies are identical
     */
    public function equals(Money $money): bool
    {
        $this->validateCurrency($money);

        return $this->amount == $money->amount;
    }

    /**
     * Returns a new Money instance, the amount of which is rounded.
     *
     * @param integer $place The positive decimal place to round the number to
     * @param integer $mode Optional PHP rounding mode constant
     * @return Money New Money instance
     */
    public function round(int $place, int $mode = PHP_ROUND_HALF_UP): Money
    {
        $amount = round($this->amount, -$place, $mode);

        return new Money($amount, $this->currency);
    }

    /**
     * Returns a new Money instance that represents
     * the sum of this Money object and addend value.
     *
     * @param Money $addend Money instance to add
     * @return Money New Money instance
     */
    public function plus(Money $addend): Money
    {
        $this->validateCurrency($addend);

        $result = $this->amount + $addend->amount;

        return new Money($result, $this->currency);
    }

    /**
     * Returns a new Money instance that represents
     * the difference of this Money and subtrahend value.
     *
     * @param Money $subtrahend Money instance to subtract
     * @return Money New Money instance
     */
    public function minus(Money $subtrahend): Money
    {
        $this->validateCurrency($subtrahend);

        $result = $this->amount - $subtrahend->amount;

        return new Money($result, $this->currency);
    }

    /**
     * Returns a new Money instance that represents the
     * quotient of this Money by the given factor.
     *
     * @param float $divisor The divisor non-zero value
     * @param integer $roundingMode Optional PHP rounding mode constant
     * @return Money New Money instance
     */
    public function divideBy(float $divisor, int $roundingMode = PHP_ROUND_HALF_UP): Money
    {
        $result = round($this->amount / $divisor, 0, $roundingMode);

        return new Money($result, $this->currency);
    }

    /**
     * Returns a new Money instance that represents the
     * product of this instance by the given factors.
     *
     * @param float $multiplier The multiplier float value
     * @param integer $roundingMode Optional PHP rounding mode constant
     * @return Money New Money instance
     */
    public function multiplyBy(float $multiplier, int $roundingMode = PHP_ROUND_HALF_UP): Money
    {
        $result = round($this->amount * $multiplier, 0, $roundingMode);

        return new Money($result, $this->currency);
    }

    /**
     * Returns true if this Money is greater than a given.
     *
     * @param Money $money The money with which compare
     * @return bool True if is greater than a given
     */
    public function gt(Money $money): bool
    {
        $this->validateCurrency($money);

        return $this->amount > $money->amount;
    }

    /**
     * Returns true if this Money is greater than or equal to a given.
     *
     * @param Money $money The money with which compare
     * @return bool True if is greater than or equal to a given
     */
    public function gte(Money $money): bool
    {
        $this->validateCurrency($money);

        return $this->amount >= $money->amount;
    }

    /**
     * Returns true if this Money is less than a given.
     *
     * @param Money $money The money with which compare.
     * @return bool True if is less than a given
     */
    public function lt(Money $money): bool
    {
        $this->validateCurrency($money);

        return $this->amount < $money->amount;
    }

    /**
     * Returns true if this Money is less than or equal to a given.
     *
     * @param Money $money The money with which compare
     * @return bool True if is less than or equal to a given
     */
    public function lte(Money $money): bool
    {
        $this->validateCurrency($money);

        return $this->amount <= $money->amount;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        if (isset(self::$serializeCallback)) {
            return call_user_func(self::$serializeCallback, $this);
        }

        return [
            'amount' => $this->amount,
            'currency' => $this->currency
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        if (isset(self::$formatterCallback)) {
            return call_user_func(self::$formatterCallback, $this);
        }

        return sprintf('%s %s', $this->amount, $this->currency);
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }
}
