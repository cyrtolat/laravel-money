<?php

namespace Cyrtolat\Money\Traits\Money;

use Cyrtolat\Money\Contracts\MoneyFormatterContract;
use Cyrtolat\Money\Providers\MoneyFormatterProvider;

/**
 * The Money formatting trait.
 */
trait HasFormatting
{
    /**
     * Returns a string representation of this instance of the Money class.
     *
     * @param MoneyFormatterContract|null $formatter The Money Formatter instance or nothing to use default formatter.
     * @return string
     */
    public function format(MoneyFormatterContract $formatter = null): string
    {
        if ($formatter instanceof MoneyFormatterContract) {
            return $formatter->format($this);
        }

        $provider = MoneyFormatterProvider::getInstance();
        $formatter = $provider->getFormatter();

        return $formatter->format($this);
    }
}
