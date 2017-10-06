<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\AddressClient;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * Class AddressController
 *
 * TEST CONTROLLER
 *
 * @package App\Http\Controllers\Web
 */
class AddressController extends Controller
{
    /**
     * @var
     */
    private $token;
    /**
     * @var ApiContext
     */
    private $apiContext;

    /**
     * AddressController constructor.
     * @param ApiContext $apiContext
     */
    public function __construct(ApiContext $apiContext)
    {
        $this->apiContext = $apiContext;
    }

    /**
     *
     */
    public function index()
    {

    }

    /**
     *
     */
    public function create()
    {
        $addressClient = new AddressClient($this->apiContext);
        $addressKeyChain = $addressClient->generateAddress();
        dd($addressKeyChain);
    }

    /**
     * @param $address
     */
    public function balance($address)
    {
        $addressClient = new AddressClient($this->apiContext);
        $addressBalance = $addressClient->getBalance($address);
        dd($addressBalance);
    }

    /**
     * @param $address
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function qr($address)
    {
        return view('address.qr', ['address' => $address]);
    }


}
