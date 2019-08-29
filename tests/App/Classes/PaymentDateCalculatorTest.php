<?php

namespace App\Command;

use App\Classes\PaymentDateCalculator;

/**
 * PaymentDateCalculator test class
 *
 * @author Jan de Wit <cobaltjeh@gmail.com>
 */
class PaymentDateCalculatorTest extends \PHPUnit_Framework_TestCase
{
    const DEFAULT_BONUS_DAY = 15;

    /**
     * @var PaymentDateCalculator
     */
    private $paymentDateCalculator;


    /**
     * phpunit setup method
     */
    public function setUp()
    {
        $this->paymentDateCalculator = new PaymentDateCalculator(self::DEFAULT_BONUS_DAY);
    }

    /**
     * Test
     *
     * @test
     */
    public function constructor()
    {
        $this->assertTrue($this->paymentDateCalculator instanceof PaymentDateCalculator);
    }

    /**
     * @test
     */
    public function calculateMonth1()
    {
        $this->assertSame($this->paymentDateCalculator->calculateMonth(1, 2019), ['January', '2019-01-31', '2019-01-15']);
    }

    /**
     * @test
     */
    public function calculateMonth2()
    {
        $this->assertSame($this->paymentDateCalculator->calculateMonth(6, 2019), ['June', '2019-06-28', '2019-06-19']);
    }

    /**
     * @test
     */
    public function calculateMonth3()
    {
        $this->assertSame($this->paymentDateCalculator->calculateMonth(12, 2019), ['December', '2019-12-31', '2019-12-18']);
    }

    /**
     * @test
     */
    public function calculateMonth4()
    {
        $this->assertSame($this->paymentDateCalculator->calculateMonth(3, 2027), ['March', '2027-03-31', '2027-03-15']);
    }
}
