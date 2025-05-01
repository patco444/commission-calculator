<?php

require_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;
use App\Service\BinListProvider;
use App\Service\TransactionReader;

// Load config
$config = require __DIR__ . '/config/config.php';

// Setup HTTP client and services
$client = new Client([
    'base_uri' => $config['binlist']['base_url'],
    'verify' => false,
]);
$binProvider = new BinListProvider($client);

$countryCode = $binProvider->getCountryCode('45417360');
print_r($countryCode);die;

$transactionReader = new TransactionReader();

// Read and process transactions
$filePath = __DIR__ . '/input/input.txt';
$transactions = $transactionReader->readFromFile($filePath);

foreach ($transactions as $transaction) {
    echo sprintf(
        "BIN: %s, Amount: %.2f, Currency: %s\n",
        $transaction->getBin(),
        $transaction->getAmount(),
        $transaction->getCurrency()
    );
}
