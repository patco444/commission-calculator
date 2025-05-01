<?php

namespace App\Service;

class CommissionCalculator
{
    private float $euRate;
    private float $nonEuRate;

    public function __construct(float $euRate = 0.01, float $nonEuRate = 0.02)
    {
        $this->euRate = $euRate;
        $this->nonEuRate = $nonEuRate;
    }

    // public function calculate(float $amount, bool $isEu): float
    // {
    //     $rate = $isEu ? $this->euRate : $this->nonEuRate;
    //     return $amount * $rate;
    // }

    /**
     * Calculates the commission based on amount and whether the country is in EU or not.
     */
    public function calculate(float $amount, bool $isEu): float
    {
        $rate = $isEu ? $this->euRate : $this->nonEuRate;
        $rawCommission = $amount * $rate;

        // Round up to nearest cent
        return ceil($rawCommission * 100) / 100;
    }
}
