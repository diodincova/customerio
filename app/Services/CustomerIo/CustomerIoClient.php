<?php

namespace App\Services\CustomerIo;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Exceptions\InvalidResponseData;

class CustomerIoClient
{
    const API_TRACK_URL = 'https://track.customer.io/api/v1/';
    const API_URL = 'https://api.customer.io/v1/api/';

    /** @var Client */
    private $httpClient;
    /** @var string */
    private $siteId;
    /** @var string */
    private $apiKey;

    public function __construct($httpClient, string $siteId, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->siteId = $siteId;
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $endpoint
     * @param array $data
     *
     * @return array
     *
     * @throws GuzzleException
     * @throws InvalidResponseData
     */
    public function put(string $endpoint, array $data): array
    {
        return $this->sendRequest('PUT', $endpoint, $this->getOptions($data));
    }

    /**
     * @param string $endpoint
     * @param array $data
     *
     * @return array
     *
     * @throws GuzzleException
     * @throws InvalidResponseData
     */
    public function get(string $endpoint, array $data): array
    {
        return $this->sendRequest('GET', $endpoint, $this->getOptions($data));
    }

    /**
     * @param string $endpoint
     * @param array $data
     *
     * @return array
     *
     * @throws GuzzleException
     * @throws InvalidResponseData
     */
    public function post(string $endpoint, array $data): array
    {
        return $this->sendRequest('POST', $endpoint, $this->getOptions($data));
    }

    /**
     * @param string $endpoint
     * @param array $data
     *
     * @return array
     *
     * @throws GuzzleException
     * @throws InvalidResponseData
     */
    public function delete(string $endpoint, array $data): array
    {
        return $this->sendRequest('DELETE', $endpoint, $this->getOptions($data));
    }

    /**
     * @return mixed|string
     */
    public function getSiteId()
    {
        return $this->siteId;
    }

    /**
     * @return mixed|string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private function getOptions(array $data): array
    {
        return [
            'auth' => $this->getAuth(),
            'headers' => [
                'Accept' => 'application/json',
            ],
            'connect_timeout' => 2,
            'timeout' => 5,
            'json' => $data
        ];
    }

    /** @return array */
    private function getAuth(): array
    {
        return [$this->siteId, $this->apiKey];
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $options
     *
     * @return array
     *
     * @throws GuzzleException
     * @throws InvalidResponseData
     */
    private function sendRequest(string $method, string $endpoint, array $options): array
    {
        try {
            $uri = self::API_TRACK_URL . $endpoint;

            $response = $this->httpClient->request($method, $uri, $options);
        } catch (Exception $e) {
            throw new InvalidResponseData($e->getMessage());
        }

        return json_decode($response->getBody()->getContents(), true);
    }
}