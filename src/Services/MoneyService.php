<?php

namespace Cyrtolat\Money\Services;

use Cyrtolat\Money\Money;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Contracts\CurrencyStorage;
use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Contracts\MoneySerializer;
use Cyrtolat\Money\Exceptions\MoneyServiceException;
use Cyrtolat\Money\Helper;

final class MoneyService
{
    /**
     * Repository with application's currency data.
     *
     * @var CurrencyStorage
     */
    private CurrencyStorage $currencyStorage;

    /**
     * Entity that serializes Money object into array.
     *
     * @var MoneySerializer
     */
    private MoneySerializer $moneySerializer;

    /**
     * Entity that render Money object into a string.
     *
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
        $this->currencyStorage = $this->resolveConfigClass(
            $config['storage'], CurrencyStorage::class
        );

        $this->moneySerializer = $this->resolveConfigClass(
            $config['serializer'], MoneySerializer::class
        );

        $this->moneyFormatter = $this->resolveConfigClass(
            $config['formatter'], MoneyFormatter::class
        );

        $this->setMoneyFormatterCallback();
        $this->setMoneySerializeCallback();
    }

    /**
     * Returns new Money instance by the given a major monetary amount.
     *
     * @param float $amount The monetary amount in a major decimal value
     * @param mixed $currency The Currency class instance or alphabetic code
     * @param integer $roundingMode An optional RoundingMode constant
     * @return Money New Money class instance
     * @throws MoneyServiceException
     */
    public function of(float $amount, mixed $currency, int $roundingMode = PHP_ROUND_HALF_UP): Money
    {
        $this->validateCurrencyType($currency);

        if (! $currency instanceof Currency) {
            $currency = $this->getCurrencyBy($currency);
        }

        $amount = Helper::calcMinorAmount($amount, $currency, $roundingMode);

        return new Money($amount, $currency->getAlphabeticCode());
    }

    /**
     * Returns new Money instance by the given a minor monetary amount.
     *
     * @param integer $amount The monetary amount in minor integer value
     * @param mixed $currency The Currency class instance or alphabetic code
     * @return Money New Money class instance
     * @throws MoneyServiceException
     */
    public function ofMinor(int $amount, mixed $currency): Money
    {
        $this->validateCurrencyType($currency);

        if (! $currency instanceof Currency) {
            $currency = $this->getCurrencyBy($currency);
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
     * Sets to all Money objects format callback.
     *
     * @return void
     */
    private function setMoneyFormatterCallback(): void
    {
        Money::setFormatterCallback(function (Money $money) {
            $currency = $this->getCurrencyBy($money->getCurrency());
            return $this->moneyFormatter->format($money->getAmount(), $currency);
        });
    }

    /**
     * Sets to all Money serialize format callback.
     *
     * @return void
     */
    private function setMoneySerializeCallback(): void
    {
        Money::setSerializeCallback(function (Money $money) {
            $currency = $this->getCurrencyBy($money->getCurrency());
            return $this->moneySerializer->toArray($money->getAmount(), $currency);
        });
    }

    /**
     * Checks the currency argument and throw an exception if the
     * type of which isn't a Currency class or string.
     *
     * @param mixed $currency
     */
    private function validateCurrencyType(mixed $currency): void
    {
        if (! $currency instanceof Currency && ! is_string($currency)) {
            throw new \InvalidArgumentException(
                "The currency prop should be a string or a Currency instance.");
        }
    }

    /**
     * Checks the existence of the given class, whether it implements
     * the given contract class and returns a new instance of it.
     *
     * @param string $class Full class name
     * @param string $contract Full contract name
     * @return mixed New instance of the given class
     */
    private function resolveConfigClass(string $class, string $contract): mixed
    {
        if (! class_exists($class) || ! is_subclass_of($class, $contract)) {
            throw new \RuntimeException("Class $class doesn't implement $contract interface.");
        }

        return new $class;
    }
}
