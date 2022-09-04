<?php

namespace Cyrtolat\Money\Formatters;

use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Support\AmountHelper;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Money;
use NumberFormatter;

/**
 * Formats the Money object in a major style with a mandatory
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
        $locale = config('money.locale', 'en');

        $this->formatter = new NumberFormatter(
            $locale, NumberFormatter::DECIMAL
        );
    }

    /**
     * {@inheritdoc}
     */
    public function format(Money $money, Currency $currency): string
    {
        $this->setMinFractionDigits($currency->getMinorUnit());
        $majorAmount = AmountHelper::calcMajorAmount($money->getAmount(), $currency);

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
