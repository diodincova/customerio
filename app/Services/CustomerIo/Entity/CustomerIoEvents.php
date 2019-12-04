<?php

namespace App\Services\CustomerIo\Entity;

use App\Exceptions\InvalidHttpRequestException;
use App\Repositories\Dictionaries\ErrorCodes;
use \GuzzleHttp\Exception\GuzzleException;
use \App\Exceptions\InvalidResponseData;

class CustomerIoEvents extends Base
{
    /**
     * Add an anonymous event (without specific customer id)
     *
     * @param array $options
     * @return array
     * @throws InvalidHttpRequestException
     * @throws InvalidResponseData
     */
    public function add(array $options): array
    {
        if (!isset($options['name'])) {
            throw new InvalidHttpRequestException(ErrorCodes::REQUEST_PARAM_MISSING, 'Customer.io-Events: event name is required!');
        }
        if (!isset($options['data']['recipient'])) {
            throw new InvalidHttpRequestException(ErrorCodes::REQUEST_PARAM_MISSING, 'Customer.io-Events: recipient is required for running campaign!');
        }

        return $this->client->post($this->eventPath(), $options);
    }
}