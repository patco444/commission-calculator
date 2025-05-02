<?php

namespace App\Service;

interface ExchangeRateProvider
{
    public function getRate(string $currency): float;
}