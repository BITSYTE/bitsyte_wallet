<?php

namespace App\Http\Controllers\Web;

use BlockCypher\Api\Wallet;
use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\WalletClient;
use BlockCypher\Rest\ApiContext;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalletsController extends Controller
{
    private $apiContext;

    public function __construct(ApiContext $apiContext)
    {
        $this->apiContext = $apiContext;
    }

    public function create($address)
    {
        $wallet = new Wallet();
        $wallet->setName('roberto_example.com');
        $wallet->setAddresses(array($address));

        $walletClient = new WalletClient($this->apiContext);
        $createdWallet = $walletClient->create($wallet);
        dd($createdWallet);
    }

    public function createWithAddress()
    {
        $walletClient = new WalletClient($this->apiContext);
        $walletGenerateAddressResponse = $walletClient->generateAddress('fernando');
        dd($walletGenerateAddressResponse);
    }
}
