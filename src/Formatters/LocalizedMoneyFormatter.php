<?php

namespace Cyrtolat\Money\Formatters;

use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Support\AmountHelper;
use Cyrtolat\Money\Currency;
use NumberFormatter;

/**
 * Formats a monetary amount according to the style
 * localized in the region using intl extension.
 */
class LocalizedMoneyFormatter implements MoneyFormatter
{
    /**
     * @var NumberFormatter
     */
    private NumberFormatter $formatter;

    /**
     * The class constructor.
     */
    public function __construct()
    {
        $locale = config('money.locale', 'eu_US');

        $this->formatter = new NumberFormatter(
            $locale, NumberFormatter::CURRENCY
        );
    }

    /**
     * {@inheritDoc}
     */
    public function format(int $amount, Currency $currency): string
    {
        $majorAmount = AmountHelper::calcMajorAmount($amount, $currency);

        return $this->formatter->formatCurrency($majorAmount, $currency->getAlphabeticCode());
    }
}