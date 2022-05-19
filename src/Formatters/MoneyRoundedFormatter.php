<?php

namespace Cyrtolat\Money\Formatters;

use Cyrtolat\Money\Money;
use Cyrtolat\Money\Contracts\MoneyFormatterContract;
use NumberFormatter;

/**
 * Formats the Money object in the style of an integer
 * with fraction rounding and with currency code.
 */
class MoneyRoundedFormatter implements MoneyFormatterContract
{
    /** @var NumberFormatter */
    private NumberFormatter $formatter;

    /**
     * The class constructor.
     */
    public function __construct()
    {
        $locale = config('money.locale', 'en_US');

        $this->formatter = new NumberFormatter(
            $locale, NumberFormatter::DECIMAL ,
        );
    }

    /** {@inheritdoc} */
    public function format(Money $money, array $params = []): string
    {
        $amount = $money->getMajorAmount();
        $currency = $money->getCurrency();

        return sprintf("%s %s",
            $this->formatter->format(round($amount)),
            $currency->getAlphabeticCode()
        );
    }
}
