<?php

namespace App\Service;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

class BinListProvider implements BinCountryProvider
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function getCountryCode(string $bin): string
    {
        try {
            $response = $this->client->request('GET', $bin);
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
