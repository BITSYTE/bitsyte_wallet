<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Address;
use App\Services\BlockCypherClientFactory;
use BlockCypher\Client\AddressClient;
use BlockCypher\Rest\ApiContext;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;

/**
 * Class AddressController
 *
 * @package App\Http\Controllers\Api\V1
 */
class AddressController extends Controller
{
    /**
     * @var ApiContext
     */
    private $apiContext;

    /**
     * @var \BlockCypher\Api\Address
     */
    private $addressKeyChain;

    /**
     * @var BlockCypherClientFactory
     */
    private $clientFactory;

    /**
     * AddressController constructor.
     *
     * @param ApiContext $apiContext
     * @param BlockCypherClientFactory $clientFactory
     */
    public function __construct(ApiContext $apiContext, BlockCypherClientFactory $clientFactory)
    {

        $this->apiContext = $apiContext;
        $this->clientFactory = $clientFactory;
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
        /** @var AddressClient $addressClient */
        $addressClient = $this->clientFactory->create('address');
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

            /** @var AddressClient $addressClient */
            $addressClient = $this->clientFactory->create('address');
            $addressBalance = $addressClient->getBalance($address->address);

            return response()->json(['data' => $addressBalance->toArray()]);
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
