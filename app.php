<?php
/**
 * Created by PhpStorm.
 * User: Plamen
 * Date: 30.4.2025 г.
 * Time: 23:52
 */

require_once __DIR__ . '/vendor/autoload.php';

use App\Service\TransactionReader;

// Path to the example input based on the requirements
$filePath = __DIR__ . '/input/input.txt';

$transactionReader = new TransactionReader();
$transactions = $transactionReader->readFromFile($filePath);

foreach ($transactions as $transaction) {
    echo sprintf(
        "BIN: %s, Amount: %.2f, Currency: %s\n",
        $transaction->getBin(),
        $transaction->getAmount(),
        $transaction->getCurrency()
    );
}