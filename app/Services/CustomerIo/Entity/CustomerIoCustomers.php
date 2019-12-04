<?php

namespace App\Services\CustomerIo\Entity;

use App\Exceptions\InvalidHttpRequestException;
use App\Repositories\Dictionaries\ErrorCodes;
use \GuzzleHttp\Exception\GuzzleException;
use \App\Exceptions\InvalidResponseData;

class CustomerIoCustomers extends Base
{
    /**
     * Add customer
     *
     * @param array $options
     * @return array
     * @throws InvalidHttpRequestException
     * @throws InvalidResponseData
     */
    public function add(array $options): array
    {
        if (!isset($options['id'])) {
            throw new InvalidHttpRequestException(ErrorCodes::REQUEST_PARAM_MISSING, 'Customer.io-Customers-add: Customer id is required!');
        }
        if (!isset($options['email'])) {
            throw new InvalidHttpRequestException(ErrorCodes::REQUEST_PARAM_MISSING, 'Customer.io-Customers-add: Email is required!');
        }

        $path = $this->customerPath($options['id']);

        return $this->client->put($path, $options);
    }

    /**
     * Get customer by email
     *
     * @param array $options
     * @return array
     * @throws InvalidHttpRequestException
     * @throws InvalidResponseData
     */
    public function get(array $options): array
    {
        if (!isset($options['email'])) {
            throw new InvalidHttpRequestException(ErrorCodes::REQUEST_PARAM_MISSING, 'Customer.io-Customers-get: Email is required!');
        }

        $path = $this->customerPath();

        return $this->client->get($path, $options);
    }

    /**
     * Update customer
     *
     * @param array $options
     * @return array
     * @throws InvalidHttpRequestException
     * @throws InvalidResponseData
     */
    public function update(array $options): array
    {
        return $this->add($options);
    }

    /**
     * Add customer event
     *
     * @param array $options
     * @return array
     * @throws InvalidHttpRequestException
     * @throws InvalidResponseData
     */
    public function event(array $options): array
    {
        if (!isset($options['id'])) {
            throw new InvalidHttpRequestException(ErrorCodes::REQUEST_PARAM_MISSING, 'Customer.io-Customers-event: Customer id is required!');
        }
        if (!isset($options['name'])) {
            throw new InvalidHttpRequestException(ErrorCodes::REQUEST_PARAM_MISSING, 'Customer.io-Customers-event: Event name is required!');
        }

        $path = $this->customerPath($options['id']);

        return $this->client->post($path . "/events", $options);
    }
}