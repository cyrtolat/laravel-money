<?php

namespace Cyrtolat\Money\Formatters;

use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Money;
use Cyrtolat\Money\Support\AmountHelper;
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
        $this->setMinFractionDigits($currency->getMinorUnit());
        $majorAmount = AmountHelper::calcMajorAmount($money->getAmount(), $currency);

        return sprintf("%s %s",
            $this->formatter->format($majorAmount),
            $currency->getAlphabeticCode()
        );
    }

    /**
     * @param int $minFractionDigits
     */
    private function setMinFractionDigits(int $value): void
    {
        $this->formatter->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, $value);
    }
}
