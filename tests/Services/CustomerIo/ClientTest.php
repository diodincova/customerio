<?php

namespace Tests\Services\CustomerIo;

use App\Services\CustomerIo\CustomerIoClient;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    public function testGet()
    {
        $testData = ['Foo' => 'Bar'];
        $testEndpoint = 'foo/bar';
        $options = [
            'auth' => ['siteId', 'apiKey'],
            'headers' => [
                'Accept' => 'application/json',
            ],
            'connect_timeout' => 2,
            'timeout' => 5,
            'json' => $testData
        ];
        $responseBody = '{"foo":"bar"}';
        $response = new Response(200, [], $responseBody);

        $httpClient = $this->getMockBuilder('GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
        $client = new CustomerIoClient($httpClient, 'siteId', 'apiKey');
        $httpClient->expects($this->once())
            ->method('request')
            ->with('GET', $client::API_TRACK_URL . $testEndpoint, $options)
            ->willReturn($response);

        $this->assertEquals(json_decode($responseBody), $client->get($testEndpoint, $testData));
    }
}