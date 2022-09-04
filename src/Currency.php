<?php

namespace Cyrtolat\Money;

use Cyrtolat\Money\Exceptions\CurrencyValidationException;
use InvalidArgumentException;
use jsonSerializable;

final class Currency implements jsonSerializable
{
    /**
     * The currency alphabetic code.
     *
     * The capital 3-letter ISO 4217 currency code.
     * For non ISO currencies no constraints are defined.
     *
     * @var string
     */
    private string $alphabeticCode;

    /**
     * The currency numeric code.
     *
     * The ISO 4217 digital currency code.
     * For non ISO currencies set it to zero.
     *
     * @var string
     */
    private string $numericCode;

    /**
     * The number of fraction digits.
     *
     * It determines the accuracy of the currency or the decimal
     * ratio of one major unit of currency in minor units.
     *
     * @var integer
     */
    private int $minorUnit;

    /**
     * The currency's entity.
     *
     * For ISO currencies this is the official name of the currency.
     * For non ISO currencies no constraints are defined.
     *
     * @var string
     */
    private string $entity;

    /**
     * The class constructor.
     *
     * @param string $alphabeticCode The currency alphabetic code.
     * @param string $numericCode The currency numeric code.
     * @param integer $minorUnit The number of fraction digits.
     * @param string $entity The currency's name.
     * @throws CurrencyValidationException
     */
    public function __construct(
        string $alphabeticCode,
        string $numericCode,
        int    $minorUnit,
        string $entity
    ) {
        if (! preg_match('/\A[A-Z]{3,4}\z/', $alphabeticCode)) {
            throw CurrencyValidationException::invalidAlphabeticCode();
        }

        if (! preg_match('/\A[0-9]+\z/', $numericCode)) {
            throw CurrencyValidationException::invalidNumericCode();
        }

        if ($minorUnit < 0) {
            throw CurrencyValidationException::invalidMinorUnit();
        }

        $this->alphabeticCode   = $alphabeticCode;
        $this->numericCode      = $numericCode;
        $this->minorUnit        = $minorUnit;
        $this->entity           = $entity;
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
     * The 3-digit ISO 4217 digital currency code.
     * For non ISO currencies no constraints are defined.
     *
     * @return string
     */
    public function getNumericCode(): string
    {
        return $this->numericCode;
    }

    /**
     * Returns the minor unit.
     *
     * It determines the accuracy of the currency or
     * the decimal ratio of one major unit of currency in minor units.
     *
     * @return integer
     */
    public function getMinorUnit(): int
    {
        return $this->minorUnit;
    }

    /**
     * Returns the currency entity.
     *
     * For ISO currencies this will be the official name of the currency.
     * For non ISO currencies no constraints are defined.
     *
     * @return string
     */
    public function getEntity(): string
    {
        return $this->entity;
    }

    /**
     * Returns true if the given Currency has the same alphabetic code.
     *
     * @param Currency $currency Currency instance for comparison
     * @return bool True if alphabetic codes are identical
     */
    public function hasSameAlphabeticCode(Currency $currency): bool
    {
        return $this->alphabeticCode == $currency->alphabeticCode;
    }

    /**
     * Returns true if the given Currency has the same numeric code.
     *
     * @param Currency $currency Currency instance for comparison
     * @return bool True if numeric codes are identical
     */
    public function hasSameNumericCode(Currency $currency): bool
    {
        return $this->numericCode == $currency->numericCode;
    }

    /**
     * Returns true if the given Currency has the same minor unit.
     *
     * @param Currency $currency Currency instance for comparison
     * @return bool True if minor units are identical
     */
    public function hasSameMinorUnit(Currency $currency): bool
    {
        return $this->minorUnit == $currency->minorUnit;
    }

    /**
     * Returns true if the given Currency has the same entity.
     *
     * @param Currency $currency Currency instance for comparison
     * @return bool True if entities are identical
     */
    public function hasSameEntity(Currency $currency): bool
    {
        return $this->entity == $currency->entity;
    }

    /**
     * Returns true if the given currency equals to this.
     *
     * @param mixed $currency The Currency instance or code
     * @return bool True if currencies are identical
     */
    public function equals(mixed $currency): bool
    {
        if (is_string($currency) == true) {
            return $this->alphabeticCode == $currency;
        }

        if (! $currency instanceof Currency) {
            throw new InvalidArgumentException(
                "The given value has wrong format or type.");
        }

        return $this->alphabeticCode == $currency->alphabeticCode
            && $this->numericCode == $currency->numericCode
            && $this->minorUnit == $currency->minorUnit
            && $this->entity == $currency->entity;
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return $this->alphabeticCode;
    }
}
