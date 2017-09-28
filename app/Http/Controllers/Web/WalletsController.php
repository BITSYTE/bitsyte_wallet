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

    public function delete(Request $request)
    {
        $names = [
            "asauer@example.org",
            "zratke@example.com",
            "th@12.com",
            "marks.eddie@example.com",
            "chyna.ruecker@example.org",
            "jon.steuber@example.com",
            "hailee90@example.com",
            "ctremblay@example.com",
            "PedroDev",
            "stefan68@example.net",
            "schmidt.zaria@example.com",
            "jmurphy@example.com",
            "jjorge@fubar.com",
            "joannie71@example.org",
            "jjorge@support.com",
            "jjorge@example.com",
            "immanuel32@example.net",
            "wehner.armand@example.org",
            "roberto_example.com",
            "rafita78@gmail.com",
            "oreichert@example.org",
            "gia17@example.org",
            "barton.cole@example.com",
            "janet24@example.org",
            "adare@example.org",
            "wschneider@example.com",
            "tschulist@example.com",
            "toy.nestor@example.com",
            "jerad45@example.com",
            "maddison53@example.org",
            "larry95@example.net",
            "gkuhic@example.com",
            "briana.rippin@example.net",
            "swiegand@example.net",
            "rylee06@example.net",
            "roberto@sgmail.com.org",
            "monty.wisoky@example.org",
            "arianna59@example.net",
            "monserrate95@example.net",
            "eduar@mxcorp.net",
            "christelle79@example.com",
            "zhayes@example.org",
            "xmcclure@example.net",
            "toy.hildegard@example.org",
            "roberto@example.com",
            "hkoelpin@example.org",
            "lucas.koepp@example.net",
            "lstark@example.net",
            "kylee73@example.net",
            "jaleel35@example.net"
        ];
        $walletClient = new WalletClient($this->apiContext);

        $collection = collect($names)->each(function($name) use($walletClient) {
            $walletClient->delete($name);
        });


    }
}
