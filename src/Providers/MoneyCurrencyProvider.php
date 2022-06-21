<?php

namespace Cyrtolat\Money\Providers;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Exceptions\CurrencyException;

/**
 * The Currency provider
 */
final class MoneyCurrencyProvider
{
    /**
     * @var MoneyCurrencyProvider|null
     */
    private static $instance;

    /**
     * The ISO currencies data.
     *
     * @var array<string, array>
     */
    private $isoCurrenciesData = [];

    /**
     * The ISO currencies by their numeric code.
     *
     * @var array<string, string>
     */
    private $isoByNumberData = [];

    /**
     * The previously created currencies.
     *
     * @var array<string, Currency>
     */
    private $storedCurrencies = [];

    /**
     * Returns the singleton instance of MoneyCurrencyProvider.
     *
     * @return MoneyCurrencyProvider
     */
    public static function getInstance(): MoneyCurrencyProvider
    {
        if (self::$instance === null) {
            self::$instance = new MoneyCurrencyProvider();
        }

        return self::$instance;
    }

    /**
     * The private singleton class constructor.
     */
    private function __construct()
    {
        $this->uploadCurrencies();
    }

    /**
     * Returns the currency matching the given currency code.
     *
     * @param string $alphabeticCode The 3-letter uppercase ISO 4217 currency code.
     * @return Currency
     * @throws CurrencyException If the currency code is unknown.
     */
    public function getCurrency(string $alphabeticCode): Currency
    {
        if (isset($this->storedCurrencies[$alphabeticCode])) {
            return $this->storedCurrencies[$alphabeticCode];
        }

        if (isset($this->isoCurrenciesData[$alphabeticCode])) {
            return $this->createCurrency($this->isoCurrenciesData[$alphabeticCode]);
        }

        throw CurrencyException::alphabeticCodeDoesntExist($alphabeticCode);
    }

    /**
     * Registers a custom currency.
     *
     * @param Currency $currency The custom Currency object.
     * @throws CurrencyException If currency already exists.
     */
    public function registerCurrency(Currency $currency): void
    {
        $alphabeticCode = $currency->getAlphabeticCode();
        $numericCode = $currency->getNumericCode();

        if (isset($this->isoCurrenciesData[$alphabeticCode])) {
            throw CurrencyException::alphabeticCodeAlreadyExists($alphabeticCode);
        }

        if (isset($this->isoByNumberData[$numericCode])) {
            throw CurrencyException::numericCodeAlreadyExists($numericCode);
        }

        if (isset($this->storedCurrencies[$alphabeticCode])) {
            throw CurrencyException::currencyAlreadyRegistered($alphabeticCode);
        }

        $this->storedCurrencies = array_merge($this->storedCurrencies, [
            $alphabeticCode => $currency
        ]);
    }

    /**
     * Returns new Currency object by given data and store it
     * in previously created array.
     *
     * @param array $data The array with currency params.
     * @return Currency
     * @throws CurrencyException If the currency code is unknown.
     */
    private function createCurrency(array $data): Currency
    {
        $currency = new Currency(
            $data['alphabeticCode'],
            $data['currencyName'],
            $data['numericCode'],
            $data['fractionDigits']
        );

        $this->storedCurrencies = array_merge($this->storedCurrencies, [
            $data['alphabeticCode'] => $currency
        ]);

        return $currency;
    }

    /**
     * Loading the currencies data from package resources.
     */
    private function uploadCurrencies(): void
    {
        $isoCurrenciesPath = __DIR__ . '/../../resources/iso-currencies.php';
        $isoByNumberPath = __DIR__ . '/../../resources/iso-by-number.php';

        if (! is_file($isoCurrenciesPath)) {
            throw new \RuntimeException('Failed to load ISO currencies data.');
        }

        if (! is_file($isoByNumberPath)) {
            throw new \RuntimeException('Failed to load ISO currencies codes by their number.');
        }

        $this->isoCurrenciesData = require $isoCurrenciesPath;
        $this->isoByNumberData = require $isoByNumberPath;
    }
}
