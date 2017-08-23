<?php

namespace App\Http\Controllers\Web;

use BitWasp\Bitcoin\Transaction\Transaction;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\TXClient;
use BlockCypher\Rest\ApiContext;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ixudra\Curl\Facades\Curl;

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
        //https://api.blockcypher.com/v1/bcy/test/txs/new    14iXYMe2rRgYtWsAkviJ4zsgj2oVXrN2up
        $response = Curl::to('https://api.blockcypher.com/v1/btc/main/txs/new')
            ->withData([
                'inputs' => [
                    [
                        'addresses' => ['12MbApk7JwJWjWyozznH3Qc6uSSQHseAZ9']
                    ],
                ],
                'outputs' => [
                    [
                        'addresses' => ['17eP2qnH38rvRFrM4Hs7PqLrAUPeAm1JAL'],
                        'value' => 10000
                    ],
                ],
            ])
            ->asJson()
            ->post();
        dd($response);

        //curl -d '{"inputs":[{"addresses": ["CEztKBAYNoUEEaPYbkyFeXC5v8Jz9RoZH9"]}],"outputs":[{"addresses": ["C1rGdt7QEPGiwPMFhNKNhHmyoWpa5X92pn"], "value": 1000000}]}'

//        $tx = new Transaction();
//
//// Tx inputs
//        $input = new \BlockCypher\Api\Input();
//        $input->addAddress("");
//        $tx->addInput($input);
//// Tx outputs
//        $output = new \BlockCypher\Api\Output();
//        $output->addAddress("");
//        $tx->addOutput($output);
//// Tx amount
//        $output->setValue(30000); // Satoshis
//
//        $txClient = new TXClient($this->apiContext);
//        $txSkeleton = $txClient->create($tx);
//
//        dd($txSkeleton);
    }
}
