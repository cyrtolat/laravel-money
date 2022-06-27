<?php

namespace Cyrtolat\Money\Serializers;

use NumberFormatter;
use Cyrtolat\Money\Contracts\MoneySerializerContract;
use Cyrtolat\Money\Money;

/**
 * Serializes an instance of the Money class in a major currency unit as a decimal.
 */
class MoneyDecimalSerializer implements MoneySerializerContract
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
            $locale, NumberFormatter::IGNORE, "#.#"
        );
    }

    /** {@inheritdoc} */
    public function toArray(Money $money, array $params = []): array
    {
        $amount = $money->getAmount();
        $currency = $money->getCurrency();
        $decimals = $currency->getFractionDigits();
        $this->formatter->setAttribute(\NumberFormatter::MIN_FRACTION_DIGITS, $decimals);

        return [
            'amount' => $this->formatter->format($amount),
            'currency' => $money->getCurrency()->getAlphabeticCode()
        ];
    }
}
