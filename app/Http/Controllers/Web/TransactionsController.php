<?php

namespace App\Http\Controllers\Web;

use BitWasp\Bitcoin\Transaction\Transaction;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\TXClient;
use BlockCypher\Rest\ApiContext;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionsController extends Controller
{
    private $token;
    private $apiContext;

    public function __construct()
    {
        $this->token = env('BLOCKCYPHER_TOKEN');
        $this->apiContext = new ApiContext(new SimpleTokenCredential($this->token));

        $this->apiContext = ApiContext::create(env('BLOCKCYPHER_ENV', 'test3'), 'btc', 'v1', new SimpleTokenCredential($this->token),
            array('log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
        );
    }

    public function create()
    {
        $tx = new Transaction();

// Tx inputs
        $input = new \BlockCypher\Api\Input();
        $input->addAddress("12MbApk7JwJWjWyozznH3Qc6uSSQHseAZ9");
        $tx->addInput($input);
// Tx outputs
        $output = new \BlockCypher\Api\Output();
        $output->addAddress("17eP2qnH38rvRFrM4Hs7PqLrAUPeAm1JAL");
        $tx->addOutput($output);
// Tx amount
        $output->setValue(30000); // Satoshis

        $txClient = new TXClient($this->apiContext);
        $txSkeleton = $txClient->create($tx);

        dd($txSkeleton);
    }
}
