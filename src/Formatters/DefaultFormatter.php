<?php

namespace Cyrtolat\Money\Formatters;

use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Money;
use NumberFormatter;

class DefaultFormatter implements MoneyFormatter
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
    public function format(Money $money, Currency $currency): string
    {
        $minorUnit = $currency->getMinorUnit();
        $amount = $money->getAmount() / pow(10, $minorUnit);

        $this->formatter->setAttribute(
            NumberFormatter::MIN_FRACTION_DIGITS, $minorUnit);

        return sprintf("%s %s",
            $this->formatter->format($amount),
            $currency->getAlphabeticCode()
        );
    }
}
