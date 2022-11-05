<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\Currency;
use InvalidArgumentException;

class CurrencyTest extends TestCase
{
    /** @test */
    public function constructor()
    {
        try { // Try to construct new Currency instance
            new Currency('RUB', '643', 2, 'Russian Ruble');
            $this->assertTrue(true); // Instance constructed
        } catch (\Exception) { $this->fail('Exception was thrown.'); }

        try { // Try to construct new Currency instance
            new Currency('USDT', '0', 8, 'Tether');
            $this->assertTrue(true); // Instance constructed
        } catch (\Exception) { $this->fail('Exception was thrown.'); }
    }

    /** @test */
    public function alphabetic_code_validation()
    {
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

    /** @test */
    public function numeric_code_validation()
    {
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

    /** @test */
    public function minor_unit_validation()
    {
        try { // The numeric code should consist of only digits or be a zero
            new Currency("Rubles", "643", -2, "Russian Ruble");
            $this->fail('Exception was not thrown.'); // Fail because instance constructed
        } catch (InvalidArgumentException) { $this->assertTrue(true); }
    }

    /** @test */
    public function getAlphabeticCode_method()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');

        $this->assertSame('RUB', $currency->alphabeticCode);
    }

    /** @test */
    public function getNumericCode_method()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');

        $this->assertSame('643', $currency->numericCode);
    }

    /** @test */
    public function getMinorUnit_method()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');

        $this->assertSame(2, $currency->minorUnit);
    }

    /** @test */
    public function getEntity_method()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');

        $this->assertSame('Russian Ruble', $currency->entity);
    }

    /** @test */
    public function equals_method_by_code()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');

        $this->assertTrue($currency->equals('RUB'));
    }

    /** @test */
    public function equals_method_by_instance()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');

        $this->assertTrue($currency->equals(
            new Currency('RUB', '643', 2, 'Russian Ruble')
        ));

        $this->assertFalse($currency->equals( // Wrong numeric code
            new Currency('RUB', '810', 2, 'Russian Ruble')
        ));

        $this->assertFalse($currency->equals( // Wrong minor unit
            new Currency('RUB', '643', 4, 'Russian Ruble')
        ));

        $this->assertFalse($currency->equals( // Wrong entity
            new Currency('RUB', '643', 2, 'Old Russian Ruble')
        ));
    }
}