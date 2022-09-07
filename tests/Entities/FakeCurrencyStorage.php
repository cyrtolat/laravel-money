<?php

namespace Cyrtolat\Money\Tests\Entities;

use Cyrtolat\Money\Contracts\CurrencyStorage;
use Cyrtolat\Money\Currency;

class FakeCurrencyStorage implements CurrencyStorage
{
    /** @var array|Currency[] */
    protected array $currencies;

    public function __construct()
    {
        $this->currencies = [
            'RUB' => new Currency('RUB', '643', 2, 'Russian Ruble'),
            'USD' => new Currency('USD', '840', 2, 'US Dollar'),
            'EUR' => new Currency('EUR', '978', 2, 'Euro')
        ];
    }

    public function find(string $alphabeticCode): ?Currency
    {
        if (isset($this->currencies[$alphabeticCode])) {
            return clone $this->currencies[$alphabeticCode];
        }

        return null;
    }
}