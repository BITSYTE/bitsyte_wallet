<?php
/**
 * Created by PhpStorm.
 * User: Herminio
 * Date: 02/10/2017
 * Time: 18:18
 */

namespace App\Services;


use BlockCypher\Api\TX;
use BlockCypher\Api\TXInput;
use BlockCypher\Api\TXOutput;

class TransactionService
{
    /**
     * @var  string
     */
    private $privateKey;
    /**
     * @var TX
     */
    private $transaction;
    /**
     * @var TXInput
     */
    private $input;
    /**
     * @var TXOutput
     */
    private $output;
    /**
     * @var BlockCypherClientFactory
     */
    private $clientFactory;

    /**
     * TransactionService constructor.
     *
     * @param TX $transaction
     * @param TXInput $input
     * @param TXOutput $output
     * @param BlockCypherClientFactory $clientFactory
     */
    public function __construct(TX $transaction, TXInput $input, TXOutput $output, BlockCypherClientFactory $clientFactory)
    {
        $this->transaction = $transaction;
        $this->input = $input;
        $this->output = $output;
        $this->clientFactory = $clientFactory;
    }

    /**
     * set sender address
     *
     * @param $address
     * @return $this
     */
    public function sender($address)
    {
        $this->input->addAddress($address);
        $this->transaction->addInput($this->input);
        return $this;
    }

    /**
     * set receiver address
     *
     * @param $address
     * @return $this
     */
    public function receiver($address)
    {
        $this->output->addAddress($address);
        $this->transaction->addOutput($this->output);
        return $this;
    }

    /**
     * set bitcoin amount
     *
     * @param $amount
     * @return $this
     */
    public function amount($amount)
    {
        $this->output->setValue($amount);

        return $this;
    }

    /**
     * set sender private key
     *
     * @param $privateKey
     * @return $this
     */
    public function signWith($privateKey)
    {
        $this->privateKey = $privateKey;

        return $this;
    }

    /**
     * @return mixed
     */
    public function send()
    {
        $txClient = $this->clientFactory->create('transaction');

        $txSkeleton = $txClient->create($this->transaction);
        $txSkeleton = $txClient->sign($txSkeleton, [$this->privateKey]);

        return $txClient->send($txSkeleton);
    }
    
}