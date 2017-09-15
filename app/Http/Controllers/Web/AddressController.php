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

    /**
     * AddressController constructor.
     * @param ApiContext $apiContext
     */
    public function __construct(ApiContext $apiContext)
    {
        $this->apiContext = $apiContext;
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
