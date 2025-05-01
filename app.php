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





// $calculator = new CommissionCalculator(
//     $config['commission']['eu'],
//     $config['commission']['non_eu']
// );
// $amountInEur = 2353;
// $isEu = false;
// $commission = $calculator->calculate($amountInEur, $isEu);
// echo number_format($commission, 2, '.', '') . PHP_EOL;



// $ratesClient = new Client([
//     'base_uri' => $config['rates']['base_url'],
//     'verify' => false,
// ]);
// $ratesProvider = new RatesProvider($ratesClient, $config['rates']['api_key']);
// //$rate = $ratesProvider->getRate("EUR");
// $rate = $ratesProvider->getRate("GBP");
// print_r($rate);
// die;



// $client = new Client([
//     'verify' => false,
// ]);
// $binProvider = new BinListProvider($client, $config['binlist']['base_url']);

// $countryCode = $binProvider->getCountryCode('45417360');
// print_r($countryCode);die;

// $transactionReader = new TransactionReader();

// // Read and process transactions
// $filePath = __DIR__ . '/input/input.txt';
// $transactions = $transactionReader->readFromFile($filePath);

// foreach ($transactions as $transaction) {
//     echo sprintf(
//         "BIN: %s, Amount: %.2f, Currency: %s\n",
//         $transaction->getBin(),
//         $transaction->getAmount(),
//         $transaction->getCurrency()
//     );
// }
