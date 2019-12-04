<?php

namespace App\Services\CustomerIo\Entity;

use App\Services\CustomerIo\CustomerIoClient;

class Base
{
    /** @var CustomerIoClient */
    protected $client;

    public function __construct()
    {
        $this->client = new CustomerIoClient();
    }

    /**
     * @param null $id
     * @param array $extra
     * @return string
     */
    protected function customerPath($id = null, array $extra = [])
    {
        return $this->generatePath('customers', $id, $extra);
    }

    /** @return string */
    protected function eventPath()
    {
        return $this->generatePath('events');
    }

    /**
     * @param $prefix
     * @param null $id
     * @param array $extra
     * @return string
     */
    private function generatePath($prefix, $id = null, array $extra = [])
    {
        $path = [
            $prefix,
        ];

        if (isset($id)) {
            $path[] = (string)$id;
        }

        if (isset($extra)) {
            $path = array_merge($path, $extra);
        }

        return implode('/', $path);
    }
}