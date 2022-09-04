<?php

namespace Cyrtolat\Money\Formatters;

use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Support\AmountHelper;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Money;
use NumberFormatter;

/**
 * Formats a monetary object according to the style
 * adopted in the region using intl extension.
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
        $locale = config('money.locale', 'en');

        $this->formatter = new NumberFormatter(
            $locale, NumberFormatter::CURRENCY
        );
    }

    /**
     * {@inheritDoc}
     */
    public function format(Money $money, Currency $currency): string
    {
        $majorAmount = AmountHelper::calcMajorAmount($money->getAmount(), $currency);

        return $this->formatter->formatCurrency($majorAmount, $currency->getAlphabeticCode());
    }
}