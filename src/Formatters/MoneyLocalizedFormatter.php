<?php

namespace Cyrtolat\Money\Formatters;

use Cyrtolat\Money\Money;
use Cyrtolat\Money\Contracts\MoneyFormatterContract;
use NumberFormatter;

/**
 * Formats the Money object in the style of a localized currency string.
 */
class MoneyLocalizedFormatter implements MoneyFormatterContract
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
            $locale, NumberFormatter::CURRENCY ,
        );
    }

    /** {@inheritdoc} */
    public function format(Money $money, array $params = []): string
    {
        $amount = $money->getMajorAmount();
        $currency = $money->getCurrency();

        return $this->formatter->formatCurrency($amount, $currency);
    }
}
