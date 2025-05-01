<?php

return [

    // Base URI for BIN lookup service
    'binlist' => [
        'base_url' => 'https://lookup.binlist.net/',
    ],

    // Base URI for exchange rates API
    'rates' => [
        // ExchangeRate.Host API is not working
        // 'base_url' => 'https://api.exchangerate.host/',
        // 'access_key' => 'b04b453826710fa9c76c166fddecb434' 
        'base_url' => 'https://api.apilayer.com/exchangerates_data/latest',
        'api_key' => 'MUTqIxWhQFk44JMBP66kAcH7PEd7GiWq'
    ],

    // Commission rates (EU vs Non-EU)
    'commission' => [
        'eu' => 0.01,
        'non_eu' => 0.02,
    ],

    // List of EU country codes
    'eu_countries' => [
        'AT', 'BE', 'BG', 'CY', 'CZ', 'DE', 'DK', 'EE', 'ES',
        'FI', 'FR', 'GR', 'HR', 'HU', 'IE', 'IT', 'LT', 'LU',
        'LV', 'MT', 'NL', 'PO', 'PT', 'RO', 'SE', 'SI', 'SK',
    ],
];
