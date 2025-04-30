<?php
/**
 * Created by PhpStorm.
 * User: Plamen
 * Date: 30.4.2025 г.
 * Time: 23:59
 */

namespace App\Service;

use App\Model\Transaction;

class TransactionReader
{
    /**
     * @param string $filePath
     * @return Transaction[]
     */
    public function readFromFile(string $filePath): array
    {
        if (!is_readable($filePath)) {
            throw new \RuntimeException("File not readable: $filePath");
        }

        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $transactions = [];

        foreach ($lines as $line) {
            $data = json_decode($line, true);

            if (isset($data['bin'], $data['amount'], $data['currency'])) {
                $transactions[] = new Transaction($data['bin'], (float)$data['amount'], $data['currency']);
            }
        }

        return $transactions;
    }
}
