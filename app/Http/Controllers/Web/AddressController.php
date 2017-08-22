<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\AddressClient;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AddressController extends Controller
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
        return view('address.qr', ['address' => $address]);
    }


}
