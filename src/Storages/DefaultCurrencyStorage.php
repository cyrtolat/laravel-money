<?php

namespace Cyrtolat\Money\Storages;

use Cyrtolat\Money\Contracts\CurrencyStorage;
use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Exceptions\CurrencyValidationException;
use RuntimeException;

final class DefaultCurrencyStorage implements CurrencyStorage
{
    /**
     * The ISO currencies by symbol code data.
     *
     * @var array<string, array>
     */
    private array $isoCurrenciesData = [];

    /**
     * The cryptocurrencies data.
     *
     * @var array<string, array>
     */
    private array $cryptocurrenciesData = [];

    /**
     * The cached currency instances.
     *
     * @@var array<string, Currency>
     */
    private array $cachedCurrencyInstances = [];

    /**
     * The class constructor.
     */
    public function __construct()
    {
        $this->uploadCurrenciesData();
    }

    /**
     * {@inheritDoc}
     */
    public function find(string $alphabeticCode): ?Currency
    {
        if (isset ($this->cachedCurrencyInstances[$alphabeticCode])) {
            return clone $this->cachedCurrencyInstances[$alphabeticCode];
        }

        if (isset ($this->isoCurrenciesData[$alphabeticCode])) {
            return $this->createCurrency($this->isoCurrenciesData[$alphabeticCode]);
        }

        if (isset ($this->cryptocurrenciesData[$alphabeticCode])) {
            return $this->createCurrency($this->cryptocurrenciesData[$alphabeticCode]);
        }

        return null;
    }

    /**
     * Loading the currencies' data from package resources.
     *
     * @return void
     */
    private function uploadCurrenciesData(): void
    {
        $isoCurrenciesPath = __DIR__ . "../../../library/iso-currencies.php";
        $cryptocurrenciesPath = __DIR__ . "../../../library/cryptocurrencies.php";

        if (! is_file($isoCurrenciesPath)) {
            throw new RuntimeException(
                "Failed to load ISO currencies data.");
        }

        if (! is_file($cryptocurrenciesPath)) {
            throw new RuntimeException(
                "Failed to load cryptocurrencies data.");
        }

        $this->isoCurrenciesData = require $isoCurrenciesPath;
        $this->cryptocurrenciesData = require $cryptocurrenciesPath;
    }

    /**
     * Returns new Currency object by given data and store it
     * in previously created array.
     *
     * @param array $data The array with currency params.
     * @return Currency
     * @throws CurrencyValidationException
     */
    private function createCurrency(array $data): Currency
    {
        $currency = new Currency(
            $data['alphabetic_code'],
            $data['numeric_code'],
            $data['minor_unit'],
            $data['entity']
        );

        $this->cachedCurrencyInstances = array_merge($this->cachedCurrencyInstances, [
            $data['alphabetic_code'] => $currency
        ]);

        return $currency;
    }
}
