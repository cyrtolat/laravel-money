<?php

namespace Cyrtolat\Money\Formatters;

use NumberFormatter;
use Cyrtolat\Money\Money;
use Cyrtolat\Money\Contracts\MoneyFormatterContract;

/**
 * Formats the Money object in the style of a decimal string with currency code.
 */
class MoneyDecimalFormatter implements MoneyFormatterContract
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
            $locale, NumberFormatter::DECIMAL,
        );
    }

    /** {@inheritdoc} */
    public function format(Money $money, array $params = []): string
    {
        $amount = $money->getMajorAmount();
        $currency = $money->getCurrency();
        $decimals = $currency->getFractionDigits();
        $this->formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $decimals);

        return sprintf("%s %s",
            $this->formatter->format($amount),
            $currency->getAlphabeticCode()
        );
    }
}