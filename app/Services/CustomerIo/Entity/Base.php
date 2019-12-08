<?php

namespace App\Services\CustomerIo\Entity;

use App\Services\CustomerIo\CustomerIoClient;

class Base
{
    /** @var CustomerIoClient */
    protected $client;

    public function __construct($client)
    {
        $this->client = $client;
    }

    /**
     * @param int|null $id
     * @param array $extra
     * @return string
     */
    protected function customerPath(int $id = null, array $extra = []): string
    {
        return $this->generatePath('customers', $id, $extra);
    }

    /** @return string */
    protected function eventPath(): string
    {
        return $this->generatePath('events');
    }

    /**
     * @param string $prefix
     * @param int|null $id
     * @param array $extra
     * @return string
     */
    private function generatePath(string $prefix, int $id = null, array $extra = []): string
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