<?php

namespace Tests\Services\CustomerIo;

use App\Services\CustomerIo\CustomerIoClient;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * @dataProvider getProvider
     */
    public function testGet($testData, $testEndpoint, $responseBody, $response)
    {
        $options = [
            'auth' => ['siteId', 'apiKey'],
            'headers' => [
                'Accept' => 'application/json',
            ],
            'connect_timeout' => 2,
            'timeout' => 5,
            'json' => $testData
        ];

        $client = $this->mockClient(['GET', CustomerIoClient::API_TRACK_URL . $testEndpoint, $options], $response);

        $this->assertEquals(json_decode($responseBody), $client->get($testEndpoint, $testData));
    }

    public function getProvider()
    {
        return [
            [['Foo' => 'Bar'], 'foo/bar', '{"foo":"bar"}', new Response(200, [], '{"foo":"bar"}')]
        ];
    }

    private function mockClient($with, $willReturn)
    {
        $httpClient = $this->getMockBuilder('GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
        $client = new CustomerIoClient($httpClient, 'siteId', 'apiKey');
        $httpClient->expects($this->once())
            ->method('request')
            ->with(...$with)
            ->willReturn($willReturn);

        return $client;
    }
}