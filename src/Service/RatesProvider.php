<?php

namespace App\Service;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class RatesProvider implements ExchangeRateProvider
{
    private ClientInterface $client;
    private string $apiKey;
    private string $baseUrl;

    public function __construct(ClientInterface $client, string $apiKey, string $baseUrl)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
    }

    /**
     * Returns the EUR exchange rate for a given currency.
     */
    public function getRate(string $currency): float
    {
        if (strtoupper($currency) === 'EUR') {
            return 1.0;
        }

        try {
            $response = $this->client->request('GET', $this->baseUrl, [
                'headers' => [
                    'apikey' => $this->apiKey,
                ],
                'query' => [
                    'base' => 'EUR',
                    'symbols' => $currency
                ]
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            if (!isset($data['rates'][$currency])) {
                throw new \RuntimeException("Missing " . $currency . " rate in response");
            }

            return $data['rates'][$currency];
        } catch (GuzzleException $e) {
            throw new \RuntimeException("Exchange rate lookup failed: " . $e->getMessage());
        }
    }
}
