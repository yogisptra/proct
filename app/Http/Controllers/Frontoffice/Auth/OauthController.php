<?php

namespace App\Http\Controllers\FrontOffice\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use App\DigiBase\Controller\BaseController;
use App\Repositories\DonaturRepository;
use App\Repositories\PasswordRessetRepository;
use App\Http\Requests\DonaturRequest;
use App\Models\Donatur;
use App\Models\DonaturOauth;
use Illuminate\Http\JsonResponse;
use App\Mail\ActivationRegisterEmail;
use Illuminate\Support\Facades\Mail;
use Socialite;
use Exception;
use Hash, DB, Cache;
use Str;


class OauthController extends BaseController
{
	use ThrottlesLogins, AuthenticatesUsers;

    public function __construct()
	{
		$this->middleware('guest:member')->except('logout');
	}

    protected $redirectTo = '/dashboard-overview';

    protected $providers = [
        'facebook', 'google', 'twitter',
    ];


	public $maxAttempts = 3;
	public $decayMinutes = 1;

    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }

    public function redirectToProvider($provider)
    {
        // return Socialite::driver($provider)->redirect();
        if (!$this->isProviderAllowed($provider)) {
            return $this->sendFailedResponse("{$provider} is not currently supported");
        }

        try {
            return Socialite::driver($provider)->redirect();
        } catch (Exception $e) {
            // You should show something simple fail message
            logger($e->getMessage());
            return $this->sendFailedResponse($e->getMessage());
        }
    }

    /**
     * Handle response of authentication redirect callback
     *
     * @param $driver
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($driver)
    {
        try {
            $donatur = Socialite::driver($driver)->user();
        } catch (Exception $e) {
            return $this->sendFailedResponse($e->getMessage());
        }
        // check for email in returned user
        return empty($donatur->email)
            ? $this->sendFailedResponse("No email id returned from {$driver} provider.")
            : $this->loginOrCreateAccount($donatur, $driver);
    }

     /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function loginOrCreateAccount($user, $provider)
    { 
        try {
            $donatur = Donatur::where('email', $user->getEmail())->first();

            // if donatur already found
            if ($donatur) {
                $donaturOauth = DonaturOauth::where('donatur_id', $donatur->id)->where('provider', $provider)->first();
                if ($donaturOauth) {
                    // update the avatar and provider that might have changed
                    $donaturOauth->update([
                        'avatar' => $user->avatar,
                        'provider' => $provider,
                        'provider_id' => $user->id,
                        'access_token' => $user->token
                    ]);
                } else {
                    // insert new provider for this donatur
                    $donaturOauth = DonaturOauth::create([
                        'id' => $this->GenerateAutoNumber('dns_donaturs-oauth'),
                        'donatur_id' => $this->GenerateAutoNumber('dns_donaturs-oauth'),
                        'avatar' => $user->getAvatar(),
                        'provider' => $provider,
                        'provider_uid' => $user->getId(),
                        'access_token' => $user->token,
                        'activated' => 1,
                    ]);

                }
            } else {
                // create a new donatur
                $data = Donatur::create([
                    'id' => $this->GenerateAutoNumber('dns_donaturs'),
                    'name' => $user->getName(),
                    'email' => $user->getEmail(),
                    'activated' => 1,
                    'api_token' => Str::random(60),
                    // donatur can use reset password to create a password
                    'password' => ''
                ]);

                $donatur = Donatur::where('email', $user->getEmail())->first();
                
                // insert new provider for this donatur
                $donaturOauth = DonaturOauth::create([
                    'id' => $this->GenerateAutoNumber('dns_donaturs-oauth'),
                    'donatur_id' => $donatur->id,
                    'avatar' => $user->getAvatar(),
                    'provider' => $provider,
                    'provider_uid' => $user->getId(),
                    'access_token' => $user->token
                ]);
            }
    
            // login the donatur
            Auth::guard('member')->login($donatur, true);
    
            return $this->sendSuccessResponse();
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
       
    }

        /**
     * Send a failed response with a msg
     *
     * @param null $msg
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedResponse($msg = null)
    {
        return redirect()->route('auth-user.login')
            ->withErrors(['msg' => $msg ?: 'Unable to login, try with another provider to login.']);
    }

     /**
     * Send a successful response
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendSuccessResponse()
    {
        return redirect()->route('dashboard-users');
    }

    protected function guard()
	{
        return Auth::guard('member');
    }
}
