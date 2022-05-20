<?php

namespace Cyrtolat\Money\Traits\Money;

use Cyrtolat\Money\Providers\MoneyFormatterProvider;

/**
 * The Money formatting trait.
 */
trait HasFormatting
{
    /**
     * Returns a string representation of this instance of the Money class.
     *
     * @return string
     */
    public function format(): string
    {
        $provider = MoneyFormatterProvider::getInstance();
        $formatter = $provider->getFormatter();

        return $formatter->format($this);
    }
}
