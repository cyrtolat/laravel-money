<?php

namespace Cyrtolat\Money;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * A Money class.
 */
final class Money implements Arrayable, Jsonable, \JsonSerializable
{
    use Traits\Money\HasFactory,
        Traits\Money\HasRounding,
        Traits\Money\HasComparing,
        Traits\Money\HasFormatting,
        Traits\Money\HasCalculations,
        Traits\Money\HasSerialization;

    /**
     * The monetary amount in a minor unit.
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
     * Returns the monetary amount in a major currency style.
     *
     * @return float
     */
    public function getAmount(): float
    {
        $subunit = pow(10, $this->currency->getFractionDigits());

        return $this->amount / $subunit;
    }

    /**
     * Returns the monetary amount in a minor currency style.
     *
     * @return integer
     */
    public function getMinorAmount(): int
    {
        return $this->amount;
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
