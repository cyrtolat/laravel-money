<?php

namespace Cyrtolat\Money\Services;

use Cyrtolat\Money\Money;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Contracts\CurrencyStorage;
use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Contracts\MoneySerializer;
use Cyrtolat\Money\Exceptions\MoneyServiceException;

final class MoneyService
{
    /**
     * @var CurrencyStorage
     */
    private CurrencyStorage $currencyStorage;

    /**
     * @var MoneySerializer
     */
    private MoneySerializer $moneySerializer;

    /**
     * @var MoneyFormatter
     */
    private MoneyFormatter $moneyFormatter;

    /**
     * The class constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->currencyStorage = $this->resolve(
            $config['storage'], CurrencyStorage::class
        );

        $this->moneySerializer = $this->resolve(
            $config['serializer'], MoneySerializer::class
        );

        $this->moneyFormatter = $this->resolve(
            $config['formatter'], MoneyFormatter::class
        );

        $this->setMoneyRenderCallback();
        $this->setMoneySerializeCallback();
    }

    /**
     * Returns new Money instance by the given a major amount and currency.
     *
     * @param float $amount The monetary amount in a major decimal value
     * @param mixed $currency The Currency class instance or alphabetic code
     * @param integer $roundingMode An optional RoundingMode constant
     * @return Money New Money class instance
     * @throws MoneyServiceException
     */
    public function ofMajor(float $amount, mixed $currency, int $roundingMode = PHP_ROUND_HALF_UP): Money
    {
        if (! $currency instanceof Currency) {
            $currency = $this->getCurrencyBy($currency);
        }

        $subunit = pow(10, $currency->getMinorUnit());
        $amount = round($amount * $subunit, 0, $roundingMode);

        return new Money($amount, $currency->getAlphabeticCode());
    }

    /**
     * Returns new Money instance by the given a minor amount and currency.
     *
     * @param integer $amount The monetary amount in minor integer value
     * @param mixed $currency The Currency class instance or alphabetic code
     * @return Money New Money class instance
     * @throws MoneyServiceException
     */
    public function ofMinor(int $amount, mixed $currency): Money
    {
        if (is_string($currency)) {
            $currency = $this->getCurrencyBy($currency);
        } else if (! $currency instanceof Currency) {
            throw new \InvalidArgumentException(
                "The currency prop type should be a string or a Currency instance.");
        }

        return new Money($amount, $currency->getAlphabeticCode());
    }

    /**
     * Returns a new Currency instance by the given code.
     *
     * @param string $code The alphabetic currency code
     * @return Currency New Currency class instance
     * @throws MoneyServiceException
     */
    public function getCurrencyBy(string $code): Currency
    {
        $currency = $this->currencyStorage->find($code);

        if ($currency instanceof Currency) {
            return $currency;
        }

        throw MoneyServiceException::unknownCurrencyCode($code);
    }

    /**
     * Todo desc..
     *
     * @return void
     */
    private function setMoneyRenderCallback(): void
    {
        Money::setRenderCallback(function (Money $money) {
            $currency = $this->getCurrencyBy($money->getCurrency());
            return $this->moneyFormatter->format($money, $currency);
        });
    }

    /**
     * Todo desc..
     *
     * @return void
     */
    private function setMoneySerializeCallback(): void
    {
        Money::setSerializeCallback(function (Money $money) {
            $currency = $this->getCurrencyBy($money->getCurrency());
            return $this->moneySerializer->toArray($money, $currency);
        });
    }

    /**
     * Todo desc..
     *
     * @param string $class
     * @param string $contract
     * @return mixed
     */
    private function resolve(string $class, string $contract)
    {
        if (! class_exists($class)) {
            throw new \RuntimeException("The configuration file does not specify a $contract class.");
        }

        if (! is_subclass_of($class, $contract)) {
            throw new \RuntimeException("Class $class doesn't implement $contract interface.");
        }

        return new $class;
    }
}
