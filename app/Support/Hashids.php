<?php

namespace App\Support;

use Hashids\Hashids as Client;

class Hashids
{
    /**
     * @var Hashids
     */
    protected $client;

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        if (empty($config)) {
            $config = config('hashids');
        }

        $this->client = new Client($config['salt'], $config['length'], $config['alphabet']);
    }

    /**
     * Encode an integer into a hashid string
     *
     * @param integer $id
     * @return string
     */
    public function encode($id)
    {
        return $this->client->encode($id);
    }

    /**
     * Decode a hashid into an integer
     *
     * @param string $hashid
     * @return integer|null
     */
    public function decode($hashid)
    {
        $decoded = $this->client->decode($hashid);

        if (is_array($decoded) && count($decoded)) {
            return $decoded[0];
        }

        return null;
    }
}
