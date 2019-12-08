<?php

namespace App\Services\CustomerIo;

use App\Models\Model;
use GuzzleHttp\Client;
use App\Services\CustomerIo\Entity\CustomerIoEvents;
use App\Services\CustomerIo\Entity\CustomerIoCustomers;
use \GuzzleHttp\Exception\GuzzleException;
use \App\Exceptions\InvalidResponseData;
use \App\Exceptions\InvalidHttpRequestException;

class CustomerIoService
{
    /** @var CustomerIoEvents */
    private $customerIoEvents;
    /** @var CustomerIoCustomers */
    private $customerIoCustomers;

    public function __construct($client)
    {
        $this->customerIoEvents = new CustomerIoEvents($client);
        $this->customerIoCustomers = new CustomerIoCustomers($client);
    }

    /**
     * @param string $siteId
     * @param string $apiKey
     * @return static
     */
    public static function createDefault(string $siteId, string $apiKey): self
    {
        $client = new CustomerIoClient(new Client(), $siteId, $apiKey);

        return new self($client);
    }

    /**
     * @param Model $model
     * @throws InvalidResponseData
     * @throws InvalidHttpRequestException
     */
    public function addStatusChangeEvent(Model $model): void
    {
        $options = [
            'name' =>'status_change', // add name of your event in Customer IO
            'data' => $this->getOptions($model),
        ];

        $this->customerIoEvents->add($options);
    }

    /**
     * @param Model $model
     * @return array
     */
    private function getOptions(Model $model): array
    {
        // Add options that you want to send to Customer IO
        return [
            'recipient' => '',
            'customer' => [
                'email' => '',
                'firstName' => '',
            ],
            'entity' => [
                'status' => $model->status,
                'entityId' => $model->id,
            ]
        ];
    }
}