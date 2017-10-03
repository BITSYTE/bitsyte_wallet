<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Address;
use App\Services\TransactionService;
use BlockCypher\Api\TX;
use BlockCypher\Api\TXInput;
use BlockCypher\Api\TXOutput;
use BlockCypher\Client\TXClient;
use BlockCypher\Rest\ApiContext;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    /**
     * @var ApiContext
     */
    private $apiContext;
    /**
     * @var TransactionService
     */
    private $service;

    /**
     * TransactionController constructor.
     *
     * @param ApiContext $apiContext
     * @param TransactionService $service
     */
    public function __construct(ApiContext $apiContext, TransactionService $service)
    {
        $this->apiContext = $apiContext;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $user = \JWTAuth::parseToken()->authenticate();

        $address = Address::whereAddress($request->sender_address)
                ->whereUserId($user-id)
                ->firstOrFail();

        $txSkeleton = $this->service
                        ->signWith($address->private)
                        ->sender($address->address)
                        ->receiver($request->receiver_address)
                        ->amount($request->amount)
                        ->send();

        return response()->json(['data' => $txSkeleton->toArray()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
