<?php
/**
 * Created by PhpStorm.
 * User: Herminio
 * Date: 02/10/2017
 * Time: 15:34
 */

namespace App\Services;


use BlockCypher\Client\AddressClient;
use BlockCypher\Client\TXClient;
use BlockCypher\Client\WalletClient;

class BlockCypherClientFactory
{
    /** @var array  */
    private $clients = [
        'wallet' => WalletClient::class,
        'address' => AddressClient::class,
        'transaction' => TXClient::class,
    ];

    /**
     * @param $client
     * @return \Illuminate\Foundation\Application|mixed
     */
    public function create($client)
    {
        if (array_key_exists($client, $this->clients)) {
           return app($this->clients[$client]);
        }

        throw new \InvalidArgumentException("This client: {$client} does not exist");
    }
}