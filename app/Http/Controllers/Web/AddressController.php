<?php

namespace App\Http\Controllers\Web;

use BaconQrCode\Encoder\QrCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\AddressClient;

class AddressController extends Controller
{
    private $token = 'e6dc11f4817741b4a1092e9cca8504ed';
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(new SimpleTokenCredential($this->token));

        $this->apiContext = ApiContext::create(env('BLOCKCYPHER_ENV', 'test3'), 'btc', 'v1', new SimpleTokenCredential($this->token),
            array('log.LogEnabled' => true, 'log.FileName' => 'BlockCypher.log', 'log.LogLevel' => 'DEBUG')
        );
    }

    public function index()
    {

    }

    public function create()
    {
        $addressClient = new AddressClient($this->apiContext);
        $addressKeyChain = $addressClient->generateAddress();
        dd($addressKeyChain);
    }

    public function balance($address)
    {
        $addressClient = new AddressClient($this->apiContext);
        $addressBalance = $addressClient->getBalance($address);
        dd($addressBalance);
    }

    public function qr($address)
    {
        echo QrCode::generate($address);
        return true;
    }


}
