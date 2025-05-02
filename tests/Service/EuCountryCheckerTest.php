<?php

namespace Tests\Service;

use App\Service\EuCountryChecker;
use PHPUnit\Framework\TestCase;

class EuCountryCheckerTest extends TestCase
{
    private EuCountryChecker $checker;

    protected function setUp(): void
    {
        $this->checker = new EuCountryChecker([
            'DE', 'FR', 'IT', 'LT', 'DK', 'ES'
        ]);
    }

    public function testCountryIsInEu()
    {
        $this->assertTrue($this->checker->isEu('DE')); // Germany
        $this->assertTrue($this->checker->isEu('es')); // Lowercase
        $this->assertTrue($this->checker->isEu('Dk')); // Mixed case
    }

    public function testCountryIsNotInEu()
    {
        $this->assertFalse($this->checker->isEu('US')); // United States
        $this->assertFalse($this->checker->isEu('JP')); // Japan
        $this->assertFalse($this->checker->isEu(''));   // Empty string
    }
}
