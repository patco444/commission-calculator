<?php

namespace App\Service;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class BinListProvider implements BinCountryProvider
{
    private ClientInterface $client;
    private string $baseUrl;

    public function __construct(ClientInterface $client, string $baseUrl)
    {
        $this->client = $client;
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    /**
     * Fetches the country code for a given BIN.
     */
    public function getCountryCode(string $bin): string
    {
        $url = $this->baseUrl . '/' . $bin;
        
        try {
            $response = $this->client->request('GET', $url);
            $data = json_decode($response->getBody()->getContents(), true);

            if (!isset($data['country']['alpha2'])) {
                throw new \RuntimeException("Invalid BIN response");
            }

            return $data['country']['alpha2'];
        } catch (GuzzleException $e) {
            throw new \RuntimeException("BIN lookup failed: " . $e->getMessage());
        }
    }
}
