<?php

namespace Cyrtolat\Money;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use InvalidArgumentException;

/**
 * A Currency class.
 */
final class Currency implements Arrayable, Jsonable
{
    use Traits\Currency\HasFactory;

    /**
     * The currency alphabetical code.
     *
     * The 3-letter uppercase ISO 4217 currency code.
     * For non ISO currencies no constraints are defined.
     *
     * @var string
     */
    private $alphabeticCode;

    /**
     * The currency numerical code.
     *
     * The ISO 4217 numeric currency code.
     * For non ISO currencies no constraints are defined.
     *
     * Set to zero if currency does not have a numerical code.
     *
     * @var string
     */
    private $numericCode;

    /**
     * The currency's official name.
     *
     * For ISO currencies this will be the official name of the currency.
     * For non ISO currencies no constraints are defined.
     *
     * @var string
     */
    private $currencyName;

    /**
     * The number of fraction digits.
     *
     * It determines the accuracy of the currency or
     * the decimal ratio of one major unit of currency in minor units.
     *
     * @var int
     */
    private $fractionDigits;

    /**
     * The class constructor.
     *
     * @param string  $alphabeticCode The currency alphabetical code.
     * @param string  $currencyName   The currency's official name.
     * @param string  $numericCode    The currency numerical code.
     * @param integer $fractionDigits The number of fraction digits.
     */
    public function __construct(
        string $alphabeticCode,
        string $currencyName,
        string $numericCode,
        int    $fractionDigits
    ) {
        if (strlen($alphabeticCode) != 3 || strtoupper($alphabeticCode) != $alphabeticCode) {
            throw new InvalidArgumentException('The alphabetic code must consist of 3 letters in uppercase.');
        }

        if ($fractionDigits < 0) {
            throw new InvalidArgumentException('The fraction digits must be greater than zero.');
        }

        if (!is_numeric($numericCode) || $numericCode != (int) $numericCode || $numericCode < 0) {
            throw new InvalidArgumentException('The numeric code must be a non-negative integer in string format.');
        }

        $this->alphabeticCode = $alphabeticCode;
        $this->numericCode = $numericCode;
        $this->currencyName = $currencyName;
        $this->fractionDigits = $fractionDigits;
    }

    /**
     * Returns the currency alphabetic code.
     *
     * The 3-letter uppercase ISO 4217 currency code.
     * For non ISO currencies no constraints are defined.
     *
     * @return string
     */
    public function getAlphabeticCode(): string
    {
        return $this->alphabeticCode;
    }

    /**
     * Returns the currency numeric code.
     *
     * The 3-digit ISO 4217 numeric currency code.
     * For non ISO currencies no constraints are defined.
     *
     * @return string
     */
    public function getNumericCode(): string
    {
        return $this->numericCode;
    }

    /**
     * Returns the currency official name.
     *
     * For ISO currencies this will be the official name of the currency.
     * For non ISO currencies no constraints are defined.
     *
     * @return string
     */
    public function getCurrencyName(): string
    {
        return $this->currencyName;
    }

    /**
     * Returns the number of fraction digits.
     *
     * It determines the accuracy of the currency or
     * the decimal ratio of one major unit of currency in minor units.
     *
     * @return integer
     */
    public function getFractionDigits(): int
    {
        return $this->fractionDigits;
    }

    /**
     * Returns whether this currency is equal to the given currency.
     *
     * @param mixed $currency The Currency class instance, alphabetical code or numerical code.
     * @return bool
     */
    public function equals($currency): bool
    {
        if ($currency instanceof Currency) {
            return $this->alphabeticCode === $currency->alphabeticCode;
        }

        if (is_numeric($currency)) {
            return $this->numericCode == $currency;
        }

        if (is_string($currency)) {
            return $this->alphabeticCode == $currency;
        }

        throw new InvalidArgumentException("Unknown param type is given.");
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'alphabetic_code' => $this->alphabeticCode,
            'numeric_code' => $this->numericCode,
            'currency_name' => $this->currencyName,
            'fraction_digits' => $this->fractionDigits
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Returns a string representation of this class instance.
     *
     * @return string
     */
    public function __toString() : string
    {
        return $this->alphabeticCode;
    }
}
