<?php

namespace Tests\Service;

use App\Service\BinListProvider;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class BinListProviderTest extends TestCase
{
    public function testReturnsCountryCodeFromApiResponse()
    {
        $mockClient = $this->createMock(ClientInterface::class);

        $mockResponse = new Response(200, [], json_encode([
            'country' => ['alpha2' => 'LT']
        ]));

        $mockClient->method('request')
            ->with('GET', 'https://api.example.com/516793')
            ->willReturn($mockResponse);

        $provider = new BinListProvider($mockClient, 'https://api.example.com/');

        $countryCode = $provider->getCountryCode('516793');

        $this->assertEquals('LT', $countryCode);
    }

    public function testThrowsExceptionIfCountryCodeMissing()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Invalid BIN response');

        $mockClient = $this->createMock(ClientInterface::class);

        $mockResponse = new Response(200, [], json_encode([]));

        $mockClient->method('request')
            ->willReturn($mockResponse);

        $provider = new BinListProvider($mockClient, 'https://api.example.com/');

        $provider->getCountryCode('123456');
    }
}
