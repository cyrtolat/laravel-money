<?php

namespace Cyrtolat\Money\Tests\Unit\Currency;

use Cyrtolat\Money\Currency;
use Cyrtolat\Money\Exceptions\CurrencyValidationException;

class BasicCurrencyTest extends CurrencyTest
{
    /** @test */
    public function test_constructor()
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
    public function test_alphabeticCode_validation()
    {
        try { // The alphabetic code should consist of only of 3 or 4 capital letters
            new Currency("Rubles", "643", 2, "Russian Ruble");
            $this->fail('Exception was not thrown.'); // Fail because instance constructed
        } catch (CurrencyValidationException) { $this->assertTrue(true); }

        try { // The alphabetic code should consist of only of 3 or 4 capital letters
            new Currency("RUBs", "643", 2, "Russian Ruble");
            $this->fail('Exception was not thrown.'); // Fail because instance constructed
        } catch (CurrencyValidationException) { $this->assertTrue(true); }

        try { // The alphabetic code should consist of only of 3 or 4 capital letters
            new Currency("", "643", 2, "Russian Ruble");
            $this->fail('Exception was not thrown.'); // Fail because instance constructed
        } catch (CurrencyValidationException) { $this->assertTrue(true); }
    }

    /** @test */
    public function test_numericCode_validation()
    {
        try { // The numeric code should consist of only digits or be a zero
            new Currency("Rubles", "-643", 2, "Russian Ruble");
            $this->fail('Exception was not thrown.'); // Fail because instance constructed
        } catch (CurrencyValidationException) { $this->assertTrue(true); }

        try { // The numeric code should consist of only digits or be a zero
            new Currency("Rubles", "b43", 2, "Russian Ruble");
            $this->fail('Exception was not thrown.'); // Fail because instance constructed
        } catch (CurrencyValidationException) { $this->assertTrue(true); }

        try { // The numeric code should consist of only digits or be a zero
            new Currency("Rubles", "", 2, "Russian Ruble");
            $this->fail('Exception was not thrown.'); // Fail because instance constructed
        } catch (CurrencyValidationException) { $this->assertTrue(true); }
    }

    /** @test */
    public function test_minorUnit_validation()
    {
        try { // The numeric code should consist of only digits or be a zero
            new Currency("Rubles", "643", -2, "Russian Ruble");
            $this->fail('Exception was not thrown.'); // Fail because instance constructed
        } catch (CurrencyValidationException) { $this->assertTrue(true); }
    }

    /** @test */
    public function test_getAlphabeticCode()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');

        $this->assertSame('RUB', $currency->getAlphabeticCode());
    }

    /** @test */
    public function test_getNumericCode()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');

        $this->assertSame('643', $currency->getNumericCode());
    }

    /** @test */
    public function test_getMinorUnit()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');

        $this->assertSame(2, $currency->getMinorUnit());
    }

    /** @test */
    public function test_getEntity()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');

        $this->assertSame('Russian Ruble', $currency->getEntity());
    }

    /** @test */
    public function test_hasSameCurrency()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');

        $this->assertTrue($currency->hasSameAlphabeticCode(
            new Currency('RUB', '810', 2, 'Russian Ruble before denomination')
        ));

        $this->assertFalse($currency->hasSameAlphabeticCode(
            new Currency('RUR', '643', 2, 'Russian Ruble')
        ));
    }

    /** @test */
    public function test_hasSameNumericCode()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');

        $this->assertTrue($currency->hasSameNumericCode(
            new Currency('RUR', '643', 2, 'Russian Ruble')
        ));

        $this->assertFalse($currency->hasSameNumericCode(
            new Currency('RUB', '810', 2, 'Russian Ruble before denomination')
        ));
    }

    /** @test */
    public function test_hasSameMinorUnit()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');

        $this->assertTrue($currency->hasSameMinorUnit(
            new Currency('RUR', '810', 2, 'Russian Ruble before denomination')
        ));

        $this->assertFalse($currency->hasSameMinorUnit(
            new Currency('RUB', '643', 3, 'Russian Ruble')
        ));
    }

    /** @test */
    public function test_hasSameEntity()
    {
        $currency = new Currency('RUB', '643', 2, 'Russian Ruble');

        $this->assertTrue($currency->hasSameEntity(
            new Currency('RUR', '810', 2, 'Russian Ruble')
        ));

        $this->assertFalse($currency->hasSameEntity(
            new Currency('RUR', '810', 2, 'Russian Ruble before denomination')
        ));
    }
}