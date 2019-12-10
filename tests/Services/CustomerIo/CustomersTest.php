<?php

namespace Customerio\Tests;

use GuzzleHttp\Client;
use App\Services\CustomerIo\CustomerIoClient;
use App\Services\CustomerIo\Entity\CustomerIoCustomers;
use PHPUnit\Framework\TestCase;

class CustomersTest extends TestCase
{
    public function testCustomerAdd()
    {
        $customer = $this->mockCustomerService('put', 'foo');
        $this->assertEquals('foo', $customer->add([
            'id' => 1,
            'email' => 'test',
        ]));
    }

    public function testCustomerGet()
    {
        $customer = $this->mockCustomerService('get', 'foo');
        $this->assertEquals('foo', $customer->get([
            'email' => 'test',
        ]));
    }

    private function mockCustomerService($method, $return)
    {
        $httpClient = $this->getMockBuilder('GuzzleHttp\Client')->disableOriginalConstructor()->getMock();
        $client = new CustomerIoClient($httpClient, 'siteId', 'apiKey');
        $client->method($method)->willReturn($return);
        $customer = new CustomerIoCustomers($client);

        return $customer;
    }
}