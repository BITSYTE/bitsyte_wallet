<?php

namespace App\Http\Controllers\Auth;

use BlockCypher\Client\AddressClient;
use DB;
use JWTAuth;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Device;
use App\Models\Address;
use BlockCypher\Api\Wallet as ApiWallet;
use Illuminate\Http\Request;
use BlockCypher\Rest\ApiContext;
use BlockCypher\Client\WalletClient;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use App\Notifications\EmailVerification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    /**
     * @var ApiContext
     */
    private $apiContext;

    /**
     * Create a new controller instance.
     *
     * @param ApiContext $apiContext
     */
    public function __construct(ApiContext $apiContext)
    {
        $this->middleware('guest');
        $this->apiContext = $apiContext;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'device.device_id' => 'required|alpha_dash|max:100|unique:devices,device_id',
            'device.type' => 'required|string|max:255',
            'device.version' => 'required',
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param Request|\Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request)));

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param Request $request
     * @internal param array $data
     * @return User
     */
    protected function create(Request $request )
    {
        if ($this->expectsJson($request)) {
            return $this->createUserFromDeviceRequest($request->all());
        }

        return $this->createUserFromWebRequest($request->all());
    }

    public function createUserFromDeviceRequest(Array $data)
    {
        try {
            DB::beginTransaction();

            $user = User::create($data);
            $user->devices()->save(new Device($data['device']));
            $this->createWallet($this->apiContext, $user);
            $this->sendNotificationTo($user);

            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $user;
    }

    public function createUserFromWebRequest(Array $data)
    {
        return $this->sendNotificationTo(User::create($data));
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        if(!$request->wantsJson()) {
            return false;
        }

        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token, 'data' => $user],200);
    }


    /**
     * Send an email notification when the user is registered
     *
     * @param User $user
     * @return User
     */
    public function sendNotificationTo(User $user)
    {
        $user->notify(new EmailVerification($user));

        return $user;
    }

    public function expectsJson(Request $request)
    {
        return $request->wantsJson() && $request->isJson();
    }

    public function createWallet(ApiContext $apiContext, User $user)
    {
        $addressClient = new AddressClient($apiContext);
        $addressKeyChain = $addressClient->generateAddress();

        $wallet = new ApiWallet();
        $wallet->setName($user->email);
        $wallet->addAddress($addressKeyChain->getAddress());

        $walletClient = new WalletClient($apiContext);
        $createdWallet = $walletClient->create($wallet);

        $address = Address::create([
            'private' => $addressKeyChain->getPrivate(),
            'public'  => $addressKeyChain->getPublic(),
            'address' => $addressKeyChain->getAddress(),
            'wif'     => $addressKeyChain->getWif(),
        ]);

        $wallet = Wallet::create([
            'token' => $createdWallet->getToken(),
            'name' => $createdWallet->getName(),
        ]);

        $wallet->addAddress($address);
        $user->addWallet($wallet);
        $user->addAddress($address);

    }
}
