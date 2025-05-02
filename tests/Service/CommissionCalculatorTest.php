<?php

namespace Tests\Service;

use App\Service\CommissionCalculator;
use PHPUnit\Framework\TestCase;

class CommissionCalculatorTest extends TestCase
{
    public function testCalculatesEuCommission()
    {
        $calculator = new CommissionCalculator(0.01, 0.02);

        $commission = $calculator->calculate(100.00, true);

        $this->assertEquals(1.00, $commission);
    }

    public function testCalculatesNonEuCommission()
    {
        $calculator = new CommissionCalculator(0.01, 0.02);

        $commission = $calculator->calculate(100.00, false);

        $this->assertEquals(2.00, $commission);
    }

    public function testCommissionIsRoundedUp()
    {
        $calculator = new CommissionCalculator(0.01, 0.02);

        // This will result in 0.7418, so it should round up to 0.75
        $commission = $calculator->calculate(37.09, false);

        $this->assertEquals(0.75, $commission);
    }
}
