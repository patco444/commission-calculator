<?php

namespace App\Service;

interface BinCountryProvider
{
    public function getCountryCode(string $bin): string;
}
