<?php

namespace Cyrtolat\Money\Tests;

use Cyrtolat\Money\Money;
use Cyrtolat\Money\Exceptions\MoneyException;

class MoneyTest extends TestCase
{
    /** @test */
    public function test_hasSameAmount_method()
    {
        // The money that others will compare with
        $money = new Money(100, 'RUB');

        // The test should pass. The currencies are identical
        $this->assertTrue($money->hasSameAmount(
            new Money(100, 'USD')
        ));

        // The test should fail. The currencies aren't identical
        $this->assertFalse($money->hasSameAmount(
            new Money(150, 'RUB')
        ));

        // The test should pass. The currencies are identical
        $this->assertTrue($money->hasSameAmount(
            new Money(100, 'RUB'),
            new Money(100, 'USD'),
            new Money(100, 'RUB'),
            new Money(100, 'EUR'),
        ));

        // The test should fail. The currencies aren't identical
        $this->assertFalse($money->hasSameAmount(
            new Money(150, 'RUB'),
            new Money(200, 'RUB'),
            new Money(250, 'RUB'),
            new Money(300, 'RUB'),
        ));
    }

    /** @test */
    public function test_hasSameCurrency_method()
    {
        // The money that others will compare with
        $money = new Money(100, 'RUB');

        // The test should pass. The currencies are identical
        $this->assertTrue($money->hasSameCurrency(
            new Money(150, 'RUB')
        ));

        // The test should fail. The currencies aren't identical
        $this->assertFalse($money->hasSameCurrency(
            new Money(150, 'USD')
        ));

        // The test should pass. The currencies are identical
        $this->assertTrue($money->hasSameCurrency(
            new Money(150, 'RUB'),
            new Money(200, 'RUB'),
            new Money(250, 'RUB'),
            new Money(300, 'RUB'),
        ));

        // The test should fail. The currencies aren't identical
        $this->assertFalse($money->hasSameCurrency(
            new Money(150, 'RUB'),
            new Money(200, 'USD'),
            new Money(250, 'RUB'),
            new Money(300, 'RUB'),
        ));
    }

    /** @test */
    public function test_equals_method()
    {
        // The money that others will compare with
        $money = new Money(100, 'RUB');

        // The test should pass. The monies are identical
        $this->assertTrue($money->equals(
            new Money(100, 'RUB')
        ));

        // The test should fail. The monies aren't identical
        $this->assertFalse($money->equals(
            new Money(150, 'RUB')
        ));

        // The test should pass. The monies are identical
        $this->assertTrue($money->equals(
            new Money(100, 'RUB'),
            new Money(100, 'RUB'),
            new Money(100, 'RUB')
        ));

        // The test should pass. The monies are identical
        $this->assertFalse($money->equals(
            new Money(100, 'RUB'),
            new Money(200, 'RUB'),
            new Money(300, 'RUB')
        ));
    }

    /** @test */
    public function test_equals_method_exception()
    {
        // The money that others will compare with
        $money = new Money(100, 'RUB');

        try { // An exception should not be thrown
            $money->equals(new Money(100, 'RUB'));
            $this->assertTrue(true); // The action is done
        } catch (MoneyException) { $this->fail('Exception was thrown.'); }

        try { // An exception should not be thrown
            $money->equals(
                new Money(100, 'RUB'),
                new Money(100, 'RUB'),
                new Money(100, 'RUB')
            );
            $this->assertTrue(true); // The action is done
        } catch (MoneyException) { $this->fail('Exception was thrown.'); }

        try { // An exception should be thrown
            $money->equals(new Money(100, 'USD'));
            $this->fail('Exception was not thrown.'); // The action is done
        } catch (MoneyException) { $this->assertTrue(true); }

        try { // An exception should be thrown
            $money->equals(
                new Money(100, 'RUB'),
                new Money(100, 'USD'),
                new Money(100, 'RUB')
            );
            $this->fail('Exception was not thrown.'); // The action is done
        } catch (MoneyException) { $this->assertTrue(true); }
    }

    /** @test */
    public function test_round_method()
    {
        // The money that will be rounded
        $money = new Money(1111, 'RUB');

        // The test should pass. The monies are identical
        $this->assertEquals($money->round(0, PHP_ROUND_HALF_UP)
            ->getAmount(), 1111
        );

        // The test should pass. The monies are identical
        $this->assertEquals($money->round(1, PHP_ROUND_HALF_UP)
            ->getAmount(), 1110
        );

        // The test should pass. The monies are identical
        $this->assertEquals($money->round(2, PHP_ROUND_HALF_UP)
            ->getAmount(), 1100
        );
    }

    /** @test */
    public function test_plus_method()
    {
        // The money to which others will be added
        $money = new Money(100, 'RUB');

        // The test should pass. Result is correct
        $this->assertEquals($money->plus(
            new Money(50, 'RUB')
        )->getAmount(), 150);

        // The test should pass. Result is correct
        $this->assertEquals($money->plus(
            new Money(50, 'RUB'),
            new Money(100, 'RUB'),
            new Money(150, 'RUB')
        )->getAmount(), 400);
    }

    /** @test */
    public function test_plus_method_exception()
    {
        // The money to which others will be added
        $money = new Money(100, 'RUB');

        try { // An exception should not be thrown
            $money->plus(new Money(150, 'RUB'));
            $this->assertTrue(true); // The action is done
        } catch (MoneyException) { $this->fail('Exception was thrown.'); }

        try { // An exception should not be thrown
            $money->plus(
                new Money(100, 'RUB'),
                new Money(150, 'RUB'),
                new Money(200, 'RUB')
            );
            $this->assertTrue(true); // The action is done
        } catch (MoneyException) { $this->fail('Exception was thrown.'); }

        try { // An exception should be thrown
            $money->plus(new Money(100, 'USD'));
            $this->fail('Exception was not thrown.'); // The action is done
        } catch (MoneyException) { $this->assertTrue(true); }

        try { // An exception should be thrown
            $money->plus(
                new Money(100, 'RUB'),
                new Money(150, 'USD'),
                new Money(200, 'RUB'),
            );
            $this->fail('Exception was not thrown.'); // The action is done
        } catch (MoneyException) { $this->assertTrue(true); }
    }

    /** @test */
    public function test_minus_method()
    {
        // The money to which others will be subtracted
        $money = new Money(100, 'RUB');

        // The test should pass. Result is correct
        $this->assertEquals($money->minus(
            new Money(75, 'RUB')
        )->getAmount(), 25);

        // The test should pass. Result is correct
        $this->assertEquals($money->minus(
            new Money(50, 'RUB'),
            new Money(10, 'RUB'),
            new Money(5, 'RUB')
        )->getAmount(), 35);
    }

    /** @test */
    public function test_minus_method_exception()
    {
        // The money to which others will be subtracted
        $money = new Money(100, 'RUB');

        try { // An exception should not be thrown
            $money->minus(new Money(150, 'RUB'));
            $this->assertTrue(true); // The action is done
        } catch (MoneyException) { $this->fail('Exception was thrown.'); }

        try { // An exception should not be thrown
            $money->minus(
                new Money(100, 'RUB'),
                new Money(150, 'RUB'),
                new Money(200, 'RUB')
            );
            $this->assertTrue(true); // The action is done
        } catch (MoneyException) { $this->fail('Exception was thrown.'); }

        try { // An exception should be thrown
            $money->minus(new Money(100, 'USD'));
            $this->fail('Exception was not thrown.'); // The action is done
        } catch (MoneyException) { $this->assertTrue(true); }

        try { // An exception should be thrown
            $money->minus(
                new Money(100, 'RUB'),
                new Money(150, 'USD'),
                new Money(200, 'RUB'),
            );
            $this->fail('Exception was not thrown.'); // The action is done
        } catch (MoneyException) { $this->assertTrue(true); }
    }

    /** @test */
    public function test_multiplyBy_method()
    {
        // The test should pass. Results is correct
        $this->assertEquals((new Money(100, 'RUB'))
            ->multiplyBy(2)->getAmount(), 200);

        // The test should pass. Results is correct
        $this->assertEquals((new Money(100, 'RUB'))
            ->multiplyBy(2.5)->getAmount(), 250);

        // The test should pass. Results is correct
        $this->assertEquals((new Money(100, 'RUB'))
            ->multiplyBy(-1.25)->getAmount(), -125);

        // The test should pass. Results is correct
        $this->assertEquals((new Money(100, 'RUB'))->multiplyBy(
            2.335, PHP_ROUND_HALF_UP)->getAmount(), 234);

        // The test should pass. Results is correct
        $this->assertEquals((new Money(100, 'RUB'))->multiplyBy(
            2.335, PHP_ROUND_HALF_DOWN)->getAmount(), 233);

        // The test should pass. Results is correct
        $this->assertEquals((new Money(100, 'RUB'))->multiplyBy(
            2.335, PHP_ROUND_HALF_EVEN)->getAmount(), 234);

        // The test should pass. Results is correct
        $this->assertEquals((new Money(100, 'RUB'))->multiplyBy(
            2.335, PHP_ROUND_HALF_ODD)->getAmount(), 233);
    }

    /** @test */
    public function test_divideBy_method()
    {
        // The test should pass. Results is correct
        $this->assertEquals((new Money(100, 'RUB'))
            ->divideBy(2)->getAmount(), 50);

        // The test should pass. Results is correct
        $this->assertEquals((new Money(100, 'RUB'))
            ->divideBy(2.5)->getAmount(), 40);

        // The test should pass. Results is correct
        $this->assertEquals((new Money(100, 'RUB'))
            ->divideBy(-1.25)->getAmount(), -80);

        // The test should pass. Results is correct
        $this->assertEquals((new Money(100, 'RUB'))->divideBy(
            1.6, PHP_ROUND_HALF_UP)->getAmount(), 63);

        // The test should pass. Results is correct
        $this->assertEquals((new Money(100, 'RUB'))->divideBy(
            1.6, PHP_ROUND_HALF_DOWN)->getAmount(), 62);

        // The test should pass. Results is correct
        $this->assertEquals((new Money(100, 'RUB'))->divideBy(
            1.6, PHP_ROUND_HALF_EVEN)->getAmount(), 62);

        // The test should pass. Results is correct
        $this->assertEquals((new Money(100, 'RUB'))->divideBy(
            1.6, PHP_ROUND_HALF_ODD)->getAmount(), 63);
    }
}