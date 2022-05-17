<?php

namespace Cyrtolat\Money\Traits\Money;

use Cyrtolat\Money\Money;
use Cyrtolat\Money\MoneyComparator;
use Cyrtolat\Money\Exceptions\ComparatorException;

/**
 * The Money comparing trait.
 */
trait HasComparisons
{
    /**
     * Is this Money instance is equal to a given.
     *
     * @param Money $other The money with which compare.
     * @return bool
     * @throws ComparatorException
     */
    public function equalTo(Money $other): bool
    {
        $result = MoneyComparator::compare($this, $other);

        return $result == 0;
    }

    /**
     * Is this Money instance is not equal to a given.
     *
     * @param Money $other The money with which compare.
     * @return bool
     * @throws ComparatorException
     */
    public function notEqualTo(Money $other): bool
    {
        $result = MoneyComparator::compare($this, $other);

        return $result != 0;
    }

    /**
     * Is this Money instance is greater than given.
     *
     * @param Money $other The money with which compare.
     * @return bool
     * @throws ComparatorException
     */
    public function greaterThan(Money $other): bool
    {
        $result = MoneyComparator::compare($this, $other);

        return $result == 1;
    }

    /**
     * Is this Money instance is greater than or equal to a given.
     *
     * @param Money $other The money with which compare.
     * @return bool
     * @throws ComparatorException
     */
    public function greaterOrEqualTo(Money $other): bool
    {
        $result = MoneyComparator::compare($this, $other);

        return $result == 1 || $result == 0;
    }

    /**
     * Is this Money instance is less than to a given.
     *
     * @param Money $other The money with which compare.
     * @return bool
     * @throws ComparatorException
     */
    public function lessThan(Money $other): bool
    {
        $result = MoneyComparator::compare($this, $other);

        return $result == -1;
    }

    /**
     * Is this Money instance is less than or equal to a given.
     *
     * @param Money $other The money with which compare.
     * @return bool
     * @throws ComparatorException
     */
    public function lessOrEqualTo(Money $other): bool
    {
        $result = MoneyComparator::compare($this, $other);

        return $result == -1 || $result == 0;
    }
}
