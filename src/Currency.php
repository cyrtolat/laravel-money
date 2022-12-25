<?php

namespace Cyrtolat\Money;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Renderable;
use InvalidArgumentException;

/**
 * @property-read string $alphabeticCode
 * @property-read string $numericCode
 * @property-read integer $minorUnit
 * @property-read string $entity
 */
class Currency implements Arrayable, Jsonable, Renderable
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
     */
    public function __construct(
        string $alphabeticCode,
        string $numericCode,
        int    $minorUnit,
        string $entity
    ) {
        if (! preg_match('/\A[A-Z]{3,4}\z/', $alphabeticCode)) {
            throw new InvalidArgumentException(
                "The alphabetic code should consist of 3 or 4 capital letters.");
        }

        if (! preg_match('/\A[0-9]+\z/', $numericCode)) {
            throw new InvalidArgumentException(
                "The numeric code should consist only of digits.");
        }

        if ($minorUnit < 0) {
            throw new InvalidArgumentException(
                "The minor unit must be greater than zero.");
        }

        $this->alphabeticCode = $alphabeticCode;
        $this->numericCode = $numericCode;
        $this->minorUnit = $minorUnit;
        $this->entity = $entity;
    }

    /**
     * Implicit getting hidden properties.
     *
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        return property_exists($this, $property)
            ? $this->$property : null;
    }

    /**
     * Returns true if the given currency equals to this.
     *
     * @param mixed $currency The Currency instance or code
     * @return bool True if currencies are identical
     */
    public function equals(mixed $currency): bool
    {
        if (is_string($currency) || is_integer($currency)) {
            return $this->alphabeticCode == $currency
                || $this->numericCode == $currency;
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
    public function toArray()
    {
        return [
            'alphabetic_code' => $this->alphabeticCode,
            'numeric_code' => $this->numericCode,
            'minor_unit' => $this->minorUnit,
            'entity' => $this->entity
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }

    /**
     * {@inheritDoc}
     */
    public function render()
    {
        return $this->alphabeticCode;
    }
}
