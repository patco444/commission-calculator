<?php

require_once __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;
use App\Service\BinListProvider;
use App\Service\RatesProvider;
use App\Service\TransactionReader;
use App\Service\CommissionCalculator;
use App\Service\EuCountryChecker;

// Load configuration file
$config = require __DIR__ . '/config/config.php';

$httpClient = new Client(['verify' => false]);

$binProvider = new BinListProvider($httpClient, $config['binlist']['base_url']);
$ratesProvider = new RatesProvider($httpClient, $config['rates']['api_key'], $config['rates']['base_url']);
$transactionReader = new TransactionReader();
$euChecker = new EuCountryChecker($config['eu_countries']);
$commissionCalculator = new CommissionCalculator(
    $config['commission']['eu'],
    $config['commission']['non_eu']
);

// Read and process transactions
$filePath = __DIR__ . '/input/input.txt';
$transactions = $transactionReader->readFromFile($filePath);

foreach ($transactions as $transaction) {
    try {
        $countryCode = $binProvider->getCountryCode($transaction->getBin());
        $isEu = $euChecker->isEu($countryCode);

        $rate = $ratesProvider->getRate($transaction->getCurrency());

        $amountInEur = strtoupper($transaction->getCurrency()) === 'EUR'
            ? $transaction->getAmount()
            : $transaction->getAmount() / $rate;

        $commission = $commissionCalculator->calculate($amountInEur, $isEu);

        echo number_format($commission, 2, '.', '') . PHP_EOL;

    } catch (\Throwable $e) {
        echo "Error processing transaction (BIN: {$transaction->getBin()}): " . $e->getMessage() . PHP_EOL;
    }
}