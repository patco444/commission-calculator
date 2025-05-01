<?php

return [

    // Base URI for BIN lookup service
    'binlist' => [
        'base_url' => 'https://lookup.binlist.net/',
    ],

    // Base URI for exchange rates API
    'rates' => [
        'base_url' => 'https://api.exchangerate.host/',
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
