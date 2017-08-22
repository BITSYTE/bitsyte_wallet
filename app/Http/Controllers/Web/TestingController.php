<?php

namespace App\Http\Controllers\Web;

use BlockCypher\Api\AddressCreateResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\AddressClient;

class TestingController extends Controller
{
    private $token = 'e6dc11f4817741b4a1092e9cca8504ed';
    private $apiContext;

    public function __construct()
    {
        $this->apiContext = new ApiContext(new SimpleTokenCredential($this->token));
    }

    public function index()
    {

    }

    public function CreateAddress()
    {
        $addressClient = new AddressClient($this->apiContext['BTC.test3']);
        $addressKeyChain = $addressClient->generateAddress();
        dd($addressKeyChain);
    }

}
