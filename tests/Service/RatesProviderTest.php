<?php

namespace Tests\Service;

use App\Service\RatesProvider;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class RatesProviderTest extends TestCase
{
    public function testReturns1ForEur()
    {
        $mockClient = $this->createMock(ClientInterface::class);
        $provider = new RatesProvider($mockClient, 'fake-api-key', 'https://api.example.com/latest');

        $this->assertSame(1.0, $provider->getRate('EUR'));
    }

    public function testReturnsCorrectRateFromApi()
    {
        $mockClient = $this->createMock(ClientInterface::class);

        $mockResponse = new Response(200, [], json_encode([
            'rates' => ['USD' => 1.1]
        ]));

        $mockClient->method('request')
            ->with('GET', 'https://api.example.com/latest', $this->anything())
            ->willReturn($mockResponse);

        $provider = new RatesProvider($mockClient, 'fake-api-key', 'https://api.example.com/latest');

        $rate = $provider->getRate('USD');

        $this->assertEquals(1.1, $rate);
    }

    public function testThrowsExceptionIfRateMissing()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Missing USD rate in response');

        $mockClient = $this->createMock(ClientInterface::class);

        $mockResponse = new Response(200, [], json_encode([
            'rates' => [] // missing
        ]));

        $mockClient->method('request')
            ->willReturn($mockResponse);

        $provider = new RatesProvider($mockClient, 'fake-api-key', 'https://api.example.com/latest');

        $provider->getRate('USD');
    }
}
