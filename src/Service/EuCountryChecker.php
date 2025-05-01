<?php

namespace App\Service;

class EuCountryChecker
{
    private array $euCountryCodes;

    public function __construct(array $euCountryCodes)
    {
        $this->euCountryCodes = array_map('strtoupper', $euCountryCodes);
    }

    /**
     * Checks whether a given country is in EU.
     */
    public function isEu(string $countryCode): bool
    {
        return in_array(strtoupper($countryCode), $this->euCountryCodes, true);
    }
}
