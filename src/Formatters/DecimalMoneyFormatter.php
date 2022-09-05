<?php

namespace Cyrtolat\Money\Formatters;

use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Helper;
use NumberFormatter;

/**
 * Formats a monetary amount in a major style with a mandatory
 * fractional part and an alphabetic currency code.
 */
final class DecimalMoneyFormatter implements MoneyFormatter
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
            $locale, NumberFormatter::DECIMAL
        );
    }

    /**
     * {@inheritdoc}
     */
    public function format(int $amount, Currency $currency): string
    {
        $this->setMinFractionDigits($currency->getMinorUnit());
        $majorAmount = Helper::calcMajorAmount($amount, $currency);

        $formattedAmount = $this->formatter->format($majorAmount);

        return sprintf("%s %s", $formattedAmount, $currency->getAlphabeticCode());
    }

    /**
     * @param int $value
     */
    private function setMinFractionDigits(int $value): void
    {
        $this->formatter->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, $value);
    }
}
