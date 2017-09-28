<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Address;
use BlockCypher\Client\AddressClient;
use BlockCypher\Rest\ApiContext;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;

class AddressController extends Controller
{
    /**
     * @var ApiContext
     */
    private $apiContext;

    private $addressKeyChain;

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
        $user = JWTAuth::parseToken()->authenticate();

        $address = Address::whereUserId($user->id)->get();

        return response()->json(['data' => $address]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $addressClient = new AddressClient($this->apiContext);
        $this->addressKeyChain = $addressClient->generateAddress();

        $address = Address::create([
            'private' => $this->addressKeyChain->getPrivate(),
            'public' => $this->addressKeyChain->getPublic(),
            'address' => $this->addressKeyChain->getAddress(),
            'wif' => $this->addressKeyChain->getWif(),
        ]);

        $user->addresses()->save($address);

        return response()->json(['data' => $address], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address $address
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function show(Address $address)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($user->can('view', $address)) {

            $addressClient = new AddressClient($this->apiContext);
            $addressBalance = $addressClient->getBalance($address->address);

            return response()->json(['data' => [
                "address" => $addressBalance->getAddress(),
                "total_received" => $addressBalance->getTotalReceived(),
                "total_sent" => $addressBalance->getTotalSent(),
                "balance" => $addressBalance->getBalance(),
                "unconfirmed_balance" => $addressBalance->getUnconfirmedBalance(),
                "final_balance" => $addressBalance->getFinalBalance(),
                "n_tx" => $addressBalance->getNTx(),
                "unconfirmed_n_tx" => $addressBalance->getUnconfirmedNTx(),
                "final_n_tx" => $addressBalance->getFinalNTx(),
            ]]);
        }

        throw new AuthorizationException('You do not have permission to view this resource.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function edit(Address $address)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Address $address)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        //
    }
}
