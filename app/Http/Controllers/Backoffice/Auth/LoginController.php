<?php

namespace App\Http\Controllers\Backoffice\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use App\DigiBase\Controller\BaseController;

class LoginController extends BaseController
{

	//This trait has all the login throttling functionality.
	use ThrottlesLogins, AuthenticatesUsers;

	public $maxAttempts = 3;
	public $decayMinutes = 1;

	protected $redirectTo = '/admin/home';

	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}

	public function index()
	{
       	try {
			$title = 'Login Page';
			return view('backoffice.auth.login', compact('title'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
	}

	public function login(Request $request)
	{
       	try {
			$validator = $this->validator($request);

			if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

			//check if the user has too many login attempts.
			if (
				method_exists($this, 'hasTooManyLoginAttempts') &&
				$this->hasTooManyLoginAttempts($request)
			) {
				$this->fireLockoutEvent($request);

				return $this->sendLockoutResponse($request);
			}

			$checkAdmin = User::where('email', $request->email)->first();
			$role = $checkAdmin->roles->first();
			if($checkAdmin->id != '2020151101001'){
				if($checkAdmin->enabled != 1) {
					return redirect()->back()->with('error', 'Akun anda tidak aktif, pengajuan di reject / akun di blokir');
				}elseif($role->enabled != 1){
					return redirect()->back()->with('error', 'Role '. $role->name .' tidak aktif');
				}else {
					if ($this->attemptLogin($request)) {
						return $this->sendLoginResponse($request);
					}
				}
			}else{
				if ($checkAdmin->enabled != 1) {
					return redirect()->back()->with('error', 'Akun anda tidak aktif, pengajuan di reject / akun di blokir');
				} else {
					if ($this->attemptLogin($request)) {
						return $this->sendLoginResponse($request);
					}
				}
			}

			//keep track of login attempts from the user.
			$this->incrementLoginAttempts($request);

			//Authentication failed, redirect back with input.
			return $this->loginFailed();
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
	}


	private function validator(Request $request)
	{
		return Validator::make($request->all(), [
				$this->username() => 'required|string|exists:users',
				'password' => 'required|string|',
			], [
				'required' => ':attribute wajib diisi',
				$this->username() . '.exists' => 'User tidak terdaftar!',
			]);
	}

	protected function attemptLogin(Request $request)
	{
		return $this->guard()->attempt(
			$this->credentials($request),
			$request->filled('remember')
		);
	}


	protected function credentials(Request $request)
	{
		return $request->only($this->username(), 'password');
	}

	protected function sendLoginResponse(Request $request)
	{
		$request->session()->regenerate();

		$this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());

		//return $this->authenticated($request, $this->guard()->user())
		//	?: redirect()->route('users.index')
		//	->with('status', 'Anda login sebagai Administrator!');
	}

	protected function authenticated(Request $request, $user)
	{
		
	}

	private function loginFailed()
	{
		return redirect()
			->back()
			->withInput()
			->with('error', 'Login gagal,email atau password salah!');
	}

	public function logout(Request $request)
	{
		$this->guard()->logout();

        $this->flushSession('users');

		if ($response = $this->loggedOut($request)) {
			return $response;
		}

		return redirect()->route('sysadmin.auth')->with('status', 'Anda telah keluar!');
	}

	protected function loggedOut(Request $request)
	{
		//
	}


	//Username used in ThrottlesLogins trait
	public function username()
	{
		return 'email';
	}

	protected function guard()
	{
		return Auth::guard();
	}
}
