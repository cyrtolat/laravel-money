<?php

namespace Cyrtolat\Money\Services;

use Cyrtolat\Money\Money;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Contracts\CurrencyStorage;
use Cyrtolat\Money\Contracts\MoneyFormatter;
use Cyrtolat\Money\Contracts\MoneySerializer;
use Cyrtolat\Money\Exceptions\CurrencyNotFound;
use InvalidArgumentException;
use RuntimeException;

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
     * @throws CurrencyNotFound
     */
    public function of(float $amount, mixed $currency, int $roundingMode = PHP_ROUND_HALF_UP): Money
    {
        if (! $currency instanceof Currency) {
            $currency = $this->getCurrencyOf($currency);
        }

        $amount = calcMinorAmount($amount, $currency, $roundingMode);

        return new Money($amount, $currency->getAlphabeticCode());
    }

    /**
     * Returns new Money instance by the given a minor monetary amount.
     *
     * @param integer $amount The monetary amount in minor integer value
     * @param mixed $currency The Currency class instance or alphabetic code
     * @return Money New Money class instance
     * @throws CurrencyNotFound
     */
    public function ofMinor(int $amount, mixed $currency): Money
    {
        if (! $currency instanceof Currency) {
            $currency = $this->getCurrencyOf($currency);
        }

        return new Money($amount, $currency->getAlphabeticCode());
    }

    /**
     * Returns a new Currency instance by the given code.
     *
     * @param string $code The alphabetic currency code
     * @return Currency New Currency class instance
     * @throws CurrencyNotFound
     */
    public function getCurrencyOf(string $code): Currency
    {
        $currency = $this->currencyStorage->find($code);

        if ($currency instanceof Currency) {
            return $currency;
        }

        throw CurrencyNotFound::create($code);
    }

    /**
     * Sets to all Money objects format callback.
     *
     * @return void
     */
    private function setMoneyFormatterCallback(): void
    {
        Money::setFormatterCallback(function (Money $money) {
            $currency = $this->getCurrencyOf($money->getCurrency());
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
            $currency = $this->getCurrencyOf($money->getCurrency());
            return $this->moneySerializer->toArray($money->getAmount(), $currency);
        });
    }

    /**
     * Checks the existence of the given class, whether it implements
     * the given contract class and returns a new instance of it.
     *
     * @param mixed $class Full class name
     * @param string $contract Full contract name
     * @return mixed New instance of the given class
     */
    private function resolveConfigClass(mixed $class, string $contract): mixed
    {
        if (! class_exists($class) || ! is_subclass_of($class, $contract)) {
            throw new RuntimeException("Class $class doesn't implement $contract interface.");
        }

        return new $class;
    }
}
