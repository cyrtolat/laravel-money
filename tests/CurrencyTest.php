<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\Currency;
use InvalidArgumentException;
use Exception;

class CurrencyTest extends TestCase
{
    public function test_alphabetic_code_constructor_validation()
    {
        try { // The alphabetic code should consist of only of 3 or 4 capital letters
            new Currency("RUB", "643", 2, "Russian Ruble");
            $this->assertTrue(true); // The action is done
        } catch (Exception) { $this->fail('Exception was thrown.'); }

        try { // The alphabetic code should consist of only of 3 or 4 capital letters
            new Currency("USDT", "643", 2, "Russian Ruble");
            $this->assertTrue(true); // The action is done
        } catch (Exception) { $this->fail('Exception was thrown.'); }

        try { // The alphabetic code should consist of only of 3 or 4 capital letters
            new Currency("Rubles", "643", 2, "Russian Ruble");
            $this->fail('Exception was not thrown.'); // Fail because instance constructed
        } catch (InvalidArgumentException) { $this->assertTrue(true); }

        try { // The alphabetic code should consist of only of 3 or 4 capital letters
            new Currency("RUBs", "643", 2, "Russian Ruble");
            $this->fail('Exception was not thrown.'); // Fail because instance constructed
        } catch (InvalidArgumentException) { $this->assertTrue(true); }

        try { // The alphabetic code should consist of only of 3 or 4 capital letters
            new Currency("", "643", 2, "Russian Ruble");
            $this->fail('Exception was not thrown.'); // Fail because instance constructed
        } catch (InvalidArgumentException) { $this->assertTrue(true); }
    }

    public function test_numeric_code_constructor_validation()
    {
        try { // The numeric code should consist of only digits or be a zero
            new Currency("RUB", "643", 2, "Russian Ruble");
            $this->assertTrue(true); // The action is done
        } catch (Exception) { $this->fail('Exception was thrown.'); }

        try { // The numeric code should consist of only digits or be a zero
            new Currency("BTC", "0", 8, "Bitcoin");
            $this->assertTrue(true); // The action is done
        } catch (Exception) { $this->fail('Exception was thrown.'); }

        try { // The numeric code should consist of only digits or be a zero
            new Currency("Rubles", "-643", 2, "Russian Ruble");
            $this->fail('Exception was not thrown.'); // Fail because instance constructed
        } catch (InvalidArgumentException) { $this->assertTrue(true); }

        try { // The numeric code should consist of only digits or be a zero
            new Currency("Rubles", "b43", 2, "Russian Ruble");
            $this->fail('Exception was not thrown.'); // Fail because instance constructed
        } catch (InvalidArgumentException) { $this->assertTrue(true); }

        try { // The numeric code should consist of only digits or be a zero
            new Currency("Rubles", "", 2, "Russian Ruble");
            $this->fail('Exception was not thrown.'); // Fail because instance constructed
        } catch (InvalidArgumentException) { $this->assertTrue(true); }
    }
}