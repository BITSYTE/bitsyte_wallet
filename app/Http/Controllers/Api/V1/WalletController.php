<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Wallet;
use App\Providers\BlockCypherProvider;
use BlockCypher\Client\WalletClient;
use BlockCypher\Rest\ApiContext;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use BlockCypher\Api\Wallet as ApiWallet;

class WalletController extends Controller
{
    /**
     * @var BlockCypherProvider
     */
    private $apiContext;

    /** @var  WalletClient $walletClient */
    private $walletClient;

    public function __construct(ApiContext $apiContext)
    {
        $this->apiContext = $apiContext;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wallets = Wallet::whereUserId(JWTAuth::user()->id)->get();

        return response()->json($wallets);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(Request $request)
    {
        try {

            $wallet = new ApiWallet();
            $wallet->setName(JWTAuth::user()->email);

            $this->walletClient = new WalletClient($this->apiContext);
            $createdWallet = $this->walletClient->create($wallet);

            $wallet = Wallet::create([
                'name' => $createdWallet->getName(),
                'token' => $createdWallet->getToken(),
            ]);

            return response()->json(['data' => $wallet]);
        } catch (QueryException $e) {
            $this->walletClient->delete(JWTAuth::user()->email);
            throw $e;
        } catch (\Exception $e) {
            $this->walletClient->delete(JWTAuth::user()->email);
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Wallet $wallet)
    {
        return response()->json(['data' => $wallet]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function edit(Wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        $this->walletClient = new WalletClient($this->apiContext);

        $this->walletClient->delete($wallet->name);

        $wallet->delete();
    }
}
