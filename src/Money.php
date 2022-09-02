<?php

namespace Cyrtolat\Money;

/**
 * A Money class.
 */
final class Money
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
     * Returns true if the given Money has the same amount.
     *
     * @param Money $money Required Money instance for comparison
     * @param Money ...$other An optional group of other monies to compare
     * @return bool True if all given monies has same amount
     */
    public function hasSameAmount(Money $money, Money ...$other): bool
    {
        array_push($other, $money);

        foreach ($other as $money) {
            if ($this->amount != $money->amount) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns true if the given Money has the same currency.
     *
     * @param Money $money Required Money instance for comparison
     * @param Money ...$other An optional group of other monies to compare
     * @return bool True if all given monies has same currency
     */
    public function hasSameCurrency(Money $money, Money ...$other): bool
    {
        array_push($other, $money);

        foreach ($other as $money) {
            if ($this->currency != $money->currency) {
                return false;
            }
        }

        return true;
    }

    /**
     * Returns true if the given Money equal to this.
     *
     * @param Money $money Required Money instance for comparison
     * @param Money ...$other An optional group of other monies to compare
     * @return bool True if all given monies equal to this
     * @throws Exceptions\MoneyMismatchException
     */
    public function equals(Money $money, Money ...$other): bool
    {
        array_push($other, $money);

        foreach ($other as $money) {
            if (! $this->hasSameCurrency($money)) {
                throw Exceptions\MoneyMismatchException
                    ::hasNotSameCurrency();
            }
            if (! $this->hasSameAmount($money)) {
                return false;
            }
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
     * the sum of this Money object and addend values.
     *
     * @param Money $addend Required Money instance to add
     * @param Money ...$addends An optional group of other monies to add
     * @return Money New Money instance
     * @throws Exceptions\MoneyMismatchException
     */
    public function plus(Money $addend, Money ...$addends): Money
    {
        array_push($addends, $addend);
        $result = $this->amount;

        foreach ($addends as $addend) {
            if (! $this->hasSameCurrency($addend)) {
                throw Exceptions\MoneyMismatchException
                    ::hasNotSameCurrency();
            }

            $result += $addend->amount;
        }

        return new Money($result, $this->currency);
    }

    /**
     * Returns a new Money instance that represents
     * the difference of this Money and subtrahend values.
     *
     * @param Money $subtrahend Required Money instance to subtract
     * @param Money ...$subtrahends An optional group of other monies to subtract
     * @return Money New Money instance
     * @throws Exceptions\MoneyMismatchException
     */
    public function minus(Money $subtrahend, Money ...$subtrahends): Money
    {
        array_push($subtrahends, $subtrahend);
        $result = $this->amount;

        foreach ($subtrahends as $subtrahend) {
            if (! $this->hasSameCurrency($subtrahend)) {
                throw Exceptions\MoneyMismatchException
                    ::hasNotSameCurrency();
            }

            $result -= $subtrahend->amount;
        }

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
     * @throws Exceptions\MoneyMismatchException
     */
    public function gt(Money $money): bool
    {
        if (! $this->hasSameCurrency($money)) {
            throw Exceptions\MoneyMismatchException
                ::hasNotSameCurrency();
        }

        return $this->amount > $money->amount;
    }

    /**
     * Returns true if this Money is greater than or equal to a given.
     *
     * @param Money $money The money with which compare
     * @return bool True if is greater than or equal to a given
     * @throws Exceptions\MoneyMismatchException
     */
    public function gte(Money $money): bool
    {
        if (! $this->hasSameCurrency($money)) {
            throw Exceptions\MoneyMismatchException
                ::hasNotSameCurrency();
        }

        return $this->amount >= $money->amount;
    }

    /**
     * Returns true if this Money is less than a given.
     *
     * @param Money $money The money with which compare.
     * @return bool True if is less than a given
     * @throws Exceptions\MoneyMismatchException
     */
    public function lt(Money $money): bool
    {
        if (! $this->hasSameCurrency($money)) {
            throw Exceptions\MoneyMismatchException
                ::hasNotSameCurrency();
        }

        return $this->amount < $money->amount;
    }

    /**
     * Returns true if this Money is less than or equal to a given.
     *
     * @param Money $money The money with which compare
     * @return bool True if is less than or equal to a given
     * @throws Exceptions\MoneyMismatchException
     */
    public function lte(Money $money): bool
    {
        if (! $this->hasSameCurrency($money)) {
            throw Exceptions\MoneyMismatchException
                ::hasNotSameCurrency();
        }

        return $this->amount <= $money->amount;
    }

    /**
     * Returns a simple string representation
     * of this Money instance.
     *
     * @return string
     */
    public function __toString(): string
    {
        return sprintf('%s %s',
            $this->amount,
            $this->currency
        );
    }
}
