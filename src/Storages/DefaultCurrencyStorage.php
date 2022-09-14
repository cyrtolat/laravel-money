<?php

namespace Cyrtolat\Money\Storages;

use Cyrtolat\Money\Contracts\CurrencyStorage;
use Cyrtolat\Money\Currency;
use RuntimeException;

final class DefaultCurrencyStorage implements CurrencyStorage
{
    /**
     * The ISO currencies by numeric code.
     *
     * @var array<string, string>
     */
    private array $isoByNumericData = [];

    /**
     * The ISO currencies by alphabetic code data.
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
    public function find(string $code): ?Currency
    {
        if (isset ($this->isoByNumericData[$code])) {
            return $this->find($this->isoByNumericData[$code]);
        }

        if (isset ($this->cachedCurrencyInstances[$code])) {
            return clone $this->cachedCurrencyInstances[$code];
        }

        if (isset ($this->isoCurrenciesData[$code])) {
            return $this->createCurrency($this->isoCurrenciesData[$code]);
        }

        if (isset ($this->cryptocurrenciesData[$code])) {
            return $this->createCurrency($this->cryptocurrenciesData[$code]);
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
        $isoByNumericPath = __DIR__ . "/../../library/iso-by-numeric.php";
        $isoCurrenciesPath = __DIR__ . "/../../library/iso-currencies.php";
        $cryptocurrenciesPath = __DIR__ . "/../../library/cryptocurrencies.php";

        if (! is_file($isoByNumericPath)) {
            throw new RuntimeException(
                "Failed to load ISO by numeric data.");
        }

        if (! is_file($isoCurrenciesPath)) {
            throw new RuntimeException(
                "Failed to load ISO currencies data.");
        }

        if (! is_file($cryptocurrenciesPath)) {
            throw new RuntimeException(
                "Failed to load cryptocurrencies data.");
        }

        $this->isoByNumericData = require $isoByNumericPath;
        $this->isoCurrenciesData = require $isoCurrenciesPath;
        $this->cryptocurrenciesData = require $cryptocurrenciesPath;
    }

    /**
     * Returns new Currency object by given data and store it
     * in previously created array.
     *
     * @param array $data The array with currency params.
     * @return Currency
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

    private function cacheCurrency(Currency $currency, string $code): void
    {

    }
}
