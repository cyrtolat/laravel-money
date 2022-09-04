<?php

namespace Cyrtolat\Money\Formatters;

use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Money;
use NumberFormatter;

final class DefaultMoneyFormatter implements MoneyFormatter
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
        $locale = config('money.locale', 'en_US');

        $this->formatter = new NumberFormatter(
            $locale, NumberFormatter::DECIMAL,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function format(Money $money, Currency $currency): string
    {
        $majorAmount = $this->getMajorAmount($money, $currency);

        $this->formatter->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, $currency->getMinorUnit());

        return sprintf("%s %s",
            $this->formatter->format($majorAmount),
            $currency->getAlphabeticCode()
        );
    }

    /**
     * Todo desc..
     *
     * @param Money $money
     * @param Currency $currency
     * @return float
     */
    private function getMajorAmount(Money $money, Currency $currency): float
    {
        return $money->getAmount() / pow(10, $currency->getMinorUnit());
    }
}
