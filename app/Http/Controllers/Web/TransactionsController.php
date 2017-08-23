<?php

namespace App\Http\Controllers\Web;

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Crypto\Signer;
use BlockCypher\Rest\ApiContext;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Ixudra\Curl\Facades\Curl;
use BitcoinPHP\BitcoinECDSA\BitcoinECDSA;

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
        $new = Curl::to('https://api.blockcypher.com/v1/btc/main/txs/new')
            ->withData([
                'inputs' => [
                    [
                        'addresses' => ['17eP2qnH38rvRFrM4Hs7PqLrAUPeAm1JAL']
                    ],
                ],
                'outputs' => [
                    [
                        'addresses' => ['12MbApk7JwJWjWyozznH3Qc6uSSQHseAZ9'],
                        'value' => 1000
                    ],
                ],
            ])
            ->asJson(true)
            ->post();
        dd($new);

        $pKey = 'fadc3effee3b699881cc2c123c8df335f393460142d9fae5dd5c507b840b61f0';
        $bitcoinECDSA = new BitcoinECDSA();
        $bitcoinECDSA->setPrivateKey($pKey);

        $signatures = array_map(function($e) use ($bitcoinECDSA){
            $hash = $bitcoinECDSA->signHash($e);
            if($bitcoinECDSA->checkDerSignature('0253b7ab59e90b06f8afffcd203614a2767e88802167e907cc9f7977ea22ae459a', $e, $hash)){
                return $hash;
            }else{
                return 'ERROR:'.$hash;
            }
        },$new['tosign']);

        dd($signatures);

        $new['signatures'] = $signatures;
        $new['pubkeys'] = ['0253b7ab59e90b06f8afffcd203614a2767e88802167e907cc9f7977ea22ae459a'];
        $send = Curl::to('https://api.blockcypher.com/v1/btc/main/txs/send?token=' . $this->token)
            ->withData($new)
            ->asJson(true)
            ->post();
        dd($send);
//        curl -d '{"tx": {...}, "tosign": [ "32b5ea64c253b6b466366647458cfd60de9cd29d7dc542293aa0b8b7300cd827" ], "signatures": [ "3045022100921fc36b911094280f07d8504a80fbab9b823a25f102e2bc69b14bcd369dfc7902200d07067d47f040e724b556e5bc3061af132d5a47bd96e901429d53c41e0f8cca" ], "pubkeys": [ "02152e2bb5b273561ece7bbe8b1df51a4c44f5ab0bc940c105045e2cc77e618044" ] }' https://api.blockcypher.com/v1/bcy/test/txs/send?token=YOURTOKEN
//          ./signer 32b5ea64c253b6b466366647458cfd60de9cd29d7dc542293aa0b8b7300cd827 $PRIVATEKEY

//        3045022100921fc36b911094280f07d8504a80fbab9b823a25f102e2bc69b14bcd369dfc7902200d07067d47f040e724b556e5bc3061af132d5a47bd96e901429d53c41e0f8cca
    }

}
