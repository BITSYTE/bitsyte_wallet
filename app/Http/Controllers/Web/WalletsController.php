<?php

namespace App\Http\Controllers\Web;

use App\Facades\BlockCypherFacade;
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
        $wallet->setName('PedroDev');
        $wallet->setAddresses(array($address));

        $walletClient = new WalletClient($this->apiContext);
        $createdWallet = $walletClient->create($wallet);
        dd($createdWallet);
    }
}
