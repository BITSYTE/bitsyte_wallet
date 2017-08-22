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
