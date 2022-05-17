<?php

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
