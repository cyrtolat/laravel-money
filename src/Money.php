<?php

namespace Cyrtolat\Money;

use Closure;
use Cyrtolat\Money\Exceptions\CurrencyMismatchException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Cyrtolat\Money\Exceptions\MoneyException;
use Illuminate\Contracts\Support\Renderable;

final class Money implements Arrayable, Jsonable, Renderable
{
    /**
     * The monetary amount.
     *
     * @var integer
     */
    private int $amount;

    /**
     * The monetary currency.
     *
     * @var string
     */
    private string $currency;

    /**
     * Formatter callback
     *
     * @var null|Closure
     */
    private static ?Closure $renderCallback;

    /**
     * Serialization callback
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
     * Returns the monetary amount.
     *
     * @return integer
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * Returns the monetary currency.
     *
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * Set the render callback.
     *
     * @param  Closure  $callback
     */
    public static function setRenderCallback(Closure $callback): void
    {
        self::$renderCallback = $callback;
    }

    /**
     * Set the serializer callback.
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
     * @throws CurrencyMismatchException
     */
    private function validateCurrency(Money $money): void
    {
        if (! $this->hasSameCurrency($money)) {
            throw CurrencyMismatchException::hasNotSameCurrency();
        }
    }

    /**
     * Returns true if the given Money has the same amount.
     *
     * @param Money $money Money instance for comparison
     * @return bool True if amounts are identical
     */
    public function hasSameAmount(Money $money): bool
    {
        return $this->amount == $money->amount;
    }

    /**
     * Returns true if the given Money has the same currency.
     *
     * @param Money $money Money instance for comparison
     * @return bool True if currencies are identical
     */
    public function hasSameCurrency(Money $money): bool
    {
        return $this->currency == $money->currency;
    }

    /**
     * Returns true if the given Money equal to this.
     *
     * @param Money $money Money instance for comparison
     * @return bool True if amounts and currencies are identical
     * @throws MoneyException
     */
    public function equals(Money $money): bool
    {
        $this->validateCurrency($money);

        if (! $this->hasSameAmount($money)) {
            return false;
        }

        return true;
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
     * @throws MoneyException
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
     * @throws MoneyException
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
     * @throws MoneyException
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
     * @throws MoneyException
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
     * @throws MoneyException
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
     * @throws MoneyException
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
        if (isset(self::$renderCallback)) {
            return call_user_func(self::$renderCallback, $this);
        }

        return sprintf('%s %s',
            $this->amount, $this->currency);
    }
}
