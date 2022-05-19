<?php

namespace Cyrtolat\Money;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * A Money class.
 */
final class Money implements Arrayable, Jsonable
{
    use Traits\Money\HasFactory,
        Traits\Money\HasRounding,
        Traits\Money\HasComparing,
        Traits\Money\HasFormatting,
        Traits\Money\HasCalculations,
        Traits\Money\HasSerialization;

    /**
     * The monetary amount in a minor currency value.
     *
     * @var integer
     */
    private $amount;

    /**
     * The monetary currency instance.
     *
     * @var Currency
     */
    private $currency;

    /**
     * The class constructor.
     *
     * @param integer $amount    The monetary amount in a minor currency value.
     * @param Currency $currency The monetary currency instance.
     */
    public function __construct(int $amount, Currency $currency)
    {
        $this->amount   = $amount;
        $this->currency = $currency;
    }

    /**
     * Returns the monetary amount in a minor currency value.
     *
     * @return integer
     */
    public function getMinorAmount(): int
    {
        return $this->amount;
    }

    /**
     * Returns the monetary amount in a major currency value.
     *
     * @return float
     */
    public function getMajorAmount(): float
    {
        $subunit = pow(10, $this->currency->getFractionDigits());

        return $this->amount / $subunit;
    }

    /**
     * Returns the Currency of this Money.
     *
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * Returns the string representation of this Money object.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->format();
    }
}
