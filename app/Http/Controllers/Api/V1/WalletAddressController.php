<?php

namespace App\Http\Controllers\Api\V1;

use JWTAuth;
use App\Models\Wallet;
use App\Models\Address;
use Illuminate\Http\Request;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Api\AddressList;
use App\Http\Controllers\Controller;
use BlockCypher\Client\WalletClient;
use BlockCypher\Client\AddressClient;
use Illuminate\Database\QueryException;
use Illuminate\Auth\Access\AuthorizationException;

/**
 * Class WalletAddressController
 *
 * @package App\Http\Controllers\Api\V1
 */
class WalletAddressController extends Controller
{
    /** @var ApiContext */
    private $apiContext;

    /** @var WalletClient  */
    private $walletClient;

    /**
     * WalletAddressController constructor.
     *
     * @param ApiContext $apiContext
     */
    public function __construct(ApiContext $apiContext)
    {
        $this->apiContext = $apiContext;
        $this->walletClient = new WalletClient($this->apiContext);
    }

    /**
     * Display a listing of the related addresses.
     *
     * @param  \App\Models\Wallet $wallet
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function index(Wallet $wallet)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($user->can('view', $wallet)) {
            $address = $wallet->addresses()->get();
            return response()->json(['data' => $address]);
        }

        throw new AuthorizationException('you do not have permission to view this resource');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Wallet $wallet
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function store(Request $request, Wallet $wallet)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($user->can('add-address', $wallet)) {

            try {
                $this->walletClient = new WalletClient($this->apiContext);
                $addressClient = new AddressClient($this->apiContext);

                $addressResponse = $addressClient->generateAddress();
                $addressList = AddressList::fromAddressesArray([$addressResponse->getAddress()]);
                $walletResponse = $this->walletClient->addAddresses($wallet->name, $addressList);

                $wallet->addresses()->create($walletResponse->getAddresses());

                return response()->json(['data' => $walletResponse]);

            } catch (QueryException $exception) {
                $this->walletClient->delete($wallet->name);
                throw $exception;
            }
        }

        throw new AuthorizationException('you do not have permission to create in this resource');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wallet $wallet
     * @param  \App\Models\Address $address
     * @return \Illuminate\Http\Response
     * @throws AuthorizationException
     */
    public function show(Wallet $wallet, Address $address)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($user->can('view', $wallet) && $user->can('view', $address)) {
            return response()->json(['data' => $address]);
        }

        throw new AuthorizationException('you do not have permission to view this resource');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wallet  $wallet
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet, Address $address)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if ($user->can('delete', $wallet) && $user->can('delete', $address)) {

            $walletClient = new WalletClient($this->apiContext);
            // List of addresses to be removed from the wallet
            $addressList = AddressList::fromAddressesArray(array(
                $address->address,
            ));

            $wallet = $walletClient->removeAddresses($wallet->name, $addressList);

            return response()->json([
                'data' => [
                    'token' => $wallet->getToken(),
                    'name' => $wallet->getToken(),
                    'addresses' => $wallet->getAddresses(),
                ]
            ]);
        }
    }
}
