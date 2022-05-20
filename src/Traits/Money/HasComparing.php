<?php

namespace Cyrtolat\Money\Traits\Money;

use Cyrtolat\Money\Money;
use Cyrtolat\Money\MoneyComparator;
use Cyrtolat\Money\Exceptions\ComparatorException;

/**
 * The Money comparing trait.
 */
trait HasComparing
{
    /**
     * Returns the result of a comparison an amount with zero.
     *
     * @return bool
     */
    public function isZero(): bool
    {
        return $this->amount == 0;
    }

    /**
     * Returns true if an amount is greater than zero.
     *
     * @return bool
     */
    public function isPositive(): bool
    {
        return $this->amount > 0;
    }

    /**
     * Returns true if an amount is less than zero.
     *
     * @return bool
     */
    public function isNegative(): bool
    {
        return $this->amount < 0;
    }

    /**
     * Returns true if monies has the same currency.
     *
     * @param Money $other The money with which compare.
     * @return bool
     */
    public function hasSameCurrency(Money $other): bool
    {
        return $this->currency->equals($other->currency);
    }

    /**
     * Returns true if this instance is equal to a given.
     *
     * @param Money $other The money with which compare.
     * @return bool
     * @throws ComparatorException
     */
    public function equals(Money $other): bool
    {
        $result = MoneyComparator::compare($this, $other);

        return $result == 0;
    }

    /**
     * Returns true if this instance is greater than a given.
     *
     * @param Money $other The money with which compare.
     * @return bool
     * @throws ComparatorException
     */
    public function gt(Money $other): bool
    {
        $result = MoneyComparator::compare($this, $other);

        return $result == 1;
    }

    /**
     * Returns true if this instance is greater than or equal to a given.
     *
     * @param Money $other The money with which compare.
     * @return bool
     * @throws ComparatorException
     */
    public function gte(Money $other): bool
    {
        $result = MoneyComparator::compare($this, $other);

        return $result == 1 || $result == 0;
    }

    /**
     * Returns true if this instance is less than a given.
     *
     * @param Money $other The money with which compare.
     * @return bool
     * @throws ComparatorException
     */
    public function lt(Money $other): bool
    {
        $result = MoneyComparator::compare($this, $other);

        return $result == -1;
    }

    /**
     * Returns true if this instance is less than or equal to a given.
     *
     * @param Money $other The money with which compare.
     * @return bool
     * @throws ComparatorException
     */
    public function lte(Money $other): bool
    {
        $result = MoneyComparator::compare($this, $other);

        return $result == -1 || $result == 0;
    }
}
