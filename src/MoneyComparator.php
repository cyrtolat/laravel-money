<?php

namespace Cyrtolat\Money;

use Cyrtolat\Money\Exceptions\MoneyComparatorException;

/**
 * The Money comparator class.
 */
final class MoneyComparator
{
    /**
     * Compares the given Money instances.
     *
     * @param Money $first  First Money instance.
     * @param Money $second Second Money instance.
     *
     * @return int -1 if first < second, 0 if first == second and 1 if first > second.
     * @throws MoneyComparatorException
     */
    public static function compare(Money $first, Money $second): int
    {
        if (! $first->hasSameCurrency($second)) {
            throw MoneyComparatorException::differentCurrencies();
        }

        $firstAmount = $first->getMinorAmount();
        $secondAmount = $second->getMinorAmount();

        if ($firstAmount > $secondAmount) {
            return 1;
        }

        if ($firstAmount < $secondAmount) {
            return -1;
        }

        return 0;
    }
}
