<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Api\Address;

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
        $addressClient = new Address($this->apiContext);
        $addressKeyChain = $addressClient->getAddress();
        return $addressKeyChain;
    }

}
