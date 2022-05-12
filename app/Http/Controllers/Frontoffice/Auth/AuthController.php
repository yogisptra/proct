<?php

namespace App\Http\Controllers\FrontOffice\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use App\DigiBase\Controller\BaseController;
use App\Repositories\PasswordRessetRepository;
use App\Repositories\DonaturRepository;
use App\Models\UserOauth;
use Illuminate\Http\JsonResponse;
use App\Jobs\SendMailRegisterJob;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActivationRegisterEmail;
use Socialite, Exception, Config;

class AuthController extends BaseController
{
    //This trait has all the login throttling functionality.
	use ThrottlesLogins, AuthenticatesUsers;
    private $tokenRepository, $userRepository;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard-overview';

    protected $providers = [
        'facebook',
        'google',
        'twitter',
    ];


	public $maxAttempts = 3;
	public $decayMinutes = 1;

	public function __construct(DonaturRepository $userRepository, PasswordRessetRepository $tokenRepository)
	{
		$this->middleware('guest:member')->except('logout');
        $this->userRepository = $userRepository;
        $this->tokenRepository = $tokenRepository;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function onBoardLogin()
    {
        try {
            $title = "Akun"; 

			return view('frontoffice.auth.onboard-login', compact('title'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        try {
            $title = 'Masuk';

			return view('frontoffice.auth.login', compact('title'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    /**
     * Login Process a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function LoginProcess(Request $request)
    {
        try {           
            if(request()->input('email') != null) {
                // $validator = $this->validator($request);
                
                // if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

                //check if the user has too many login attempts.
                if (
                    method_exists($this, 'hasTooManyLoginAttempts') &&
                    $this->hasTooManyLoginAttempts($request)
                ) {
                    $this->fireLockoutEvent($request);

                    return $this->sendLockoutResponse($request);
                }

                if(is_numeric($request->get('email'))){
                    $checkUser = $this->userRepository->getByPhone($request->email);
                    if($checkUser != null) {
                        if($checkUser->activated != 1){
                            return redirect()->back()->with('error', 'Akun anda tidak aktif, pengajuan di reject / akun di blokir');
                        }else{
                            if ($this->attemptLogin($request)) {
                                return $this->sendLoginResponse($request);
                            }
                        }
                         //keep track of login attempts from the user.
                        $this->incrementLoginAttempts($request);
                        //Authentication failed, redirect back with input.
                        return $this->loginFailed();
                    } else {
                        return $this->loginFailed();
                    }
                } elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
                    $checkUser = $this->userRepository->getByEmail($request->email);
                    if($checkUser != null) {
                        if($checkUser->activated != 1){
                            return redirect()->back()->with('error', 'Akun anda tidak aktif, pengajuan di reject / akun di blokir');
                        }else{
                            if ($this->attemptLogin($request)) {
                                return $this->sendLoginResponse($request);
                            }
                        }
                         //keep track of login attempts from the user.
                        $this->incrementLoginAttempts($request);
                        //Authentication failed, redirect back with input.
                        return $this->loginFailed();
                    } else {
                        return $this->loginFailed();
                    }
                   
                }
               
            } else {
                return $this->loginFailed();
            }
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegisterForm()
    {
        try {
            $title = 'Daftar';
			return view('frontoffice.auth.register', compact('title'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request['id'] = $this->GenerateAutoNumber('dns_donaturs');
            $request['otp'] = $this->generateNumeric(6);
            $validator = $this->validatorRegister($request);
            
			if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
            $data = $this->userRepository->store($request);

            if ($data->errorInfo != null || !$data->exists) {
                 return redirect()->route('auth-user.register')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }
            if($data) {
                Mail::to($request->email)->send(new ActivationRegisterEmail($data));
                $phone = $request->phone_number;
                $message = 'Hi, Kak '.$data['name'].',
                Terima kasih telah mendaftar di Donasi.co,
                            
                Kode OTP Kakak adalah :
                ◾ Kode OTP: '.$data->otp.'
                ◾ Catatan : Jangan beritahu OTP ini ke siapapun, segala tindak kejahatan bukan tanggung jawab kami, Terimakasih.
                ';
                $this->sendWa($phone, $message);
            }

			
            return redirect()->route('auth-user.successRegister', ['id' => $this->encodeHash($request['id'])]);
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    public function successRegister($id)
    {
        try {
            $title = 'Daftar';
            $id = $this->decodeHash($id);
            $data = $this->userRepository->show($id);
 
            if($data->email_verified == 1 && $data->activated == 1){
                return redirect()->route('auth-user.login')->with('error', 'Akun anda sudah di verifikasi sebelumnya');
            }

			return view('frontoffice.auth.register-otp', compact('data', 'title'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    public function confirmationPin(Request $request, $id)
    {
        try {
            $dataOtp = $request->otp;

            $validator =  Validator::make($request->all(), [
                'otp'          => 'required',
            ],[
                'otp.required'	 	=> 'Kode :attribute Salah',
			],[
                'otp' 			=> 'OTP',
			]);
            if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

            $data = $this->userRepository->show($id);
            if($data->otp == $dataOtp){
                $verified = $this->userRepository->updateAktifasiDonatur($data->email);
                return redirect()->route('auth-user.success', ['id' => $this->encodeHash($data->id)]);
            }else{
                return redirect()->back()->with('error', 'Konfirmasi gagal dikarenakan OTP yang anda masukan tidak sesuai');
            }
            
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function showInfoUserForm($id)
    {
        try { 
            $id = $this->decodeHash($id);
            $title = 'Pendaftaran Berhasil';

            return view('frontoffice.auth.register-info', compact('title'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateInfoUser($id, UserInfoRequest $request)
    {
        try {
            $data = $this->userRepository->show($id);

            $data->update([
                'phone_number' => $request->input('phone_number'),
                'gender' => $request->input('gender'), 
                'birth_date' => $request->input('birth_date'),
            ]);
            Auth::guard('member')->login($data, true);

            return redirect()->back();
           
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    public function sendEmail($id)
    {
        try {
            $data = $this->userRepository->show($id);
            $data->update([
                'otp'   =>  $this->generateNumeric(6),
            ]);
            
            $phone = $data->phone_number;
            $message = 'Hi, Kak '.$data['name'].',
Terima kasih telah mendaftar di Donasi.co,
            
Kode OTP Kakak adalah :
◾ Kode OTP: '.$data->otp.'
◾ Catatan : Jangan beritahu OTP ini ke siapapun, segala tindak kejahatan bukan tanggung jawab kami, Terimakasih.
            ';
            $this->sendWa($phone, $message);
            // Mail::to($data->email)->send(new ActivationRegisterEmail($data));
            SendMailRegisterJob::dispatch($data)
                        ->delay(now()->addSeconds(5));
			return redirect()->back();
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    // Validator Register
    private function validatorRegister(Request $request)
	{
		return Validator::make($request->all(), [
                'name'          => 'required',
                'email'        => 'required|email|unique:dns_donaturs,email,'.$request->id,
                'phone_number' => 'required|regex:([0-9])|min:10|max:14|unique:dns_donaturs,phone_number,'.$request->id,
                'password'	=> 'required|min:6',
                'confirm_password' => 'required|same:password',
            ],[
                'name.required' 			=> ':attribute Wajib Diisi',
                'name.max'		 			=> ':attribute Melebihi :max Karakter',
                'email.required' 			=> ':attribute Wajib Diisi',
                'email.max'		 			=> ':attribute Melebihi :max Karakter',
                'email.unique'				=> ':attribute Sudah Terdaftar',
                'email.email'				=> 'Format Penulisan :attribute Salah',
                'phone_number.required' 	=> ':attribute Wajib Diisi',
                'phone_number.max' 	 		=> ':attribute Maksimal :max Digit',
                'phone_number.min' 	 		=> ':attribute Minimal :min Digit',
                'phone_number.regex'	 	=> 'Format Penulisan :attribute Salah',
                'phone_number.unique'	 	=> ':attribute Sudah Terdaftar',
                'password.required' 		=> ':attribute Wajib Diisi',
                'password.min'				=> ':attribute Kurang dari :min Karakter',
			],[
                'name' 			=> 'Nama',
                'email' 		=> 'Email',
                'phone_number' 	=> 'Phone',
                'password'      => 'Password'
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
        if(is_numeric($request->get('email'))){
            return ['phone_number'=>$request->get('email'),'password'=>$request->get('password')];
        }
        return $request->only($this->username(), 'password');
    }

    //Username used in ThrottlesLogins trait
	public function username()
	{
        if(request()->input('email') != null) {
            $login = request()->input('email');
        
            if(is_numeric($login)){
                $field = 'phone_number';
            } elseif (filter_var($login, FILTER_VALIDATE_EMAIL)) {
                $field = 'email';
            }
        
            request()->merge([$field => $login]);
        
            return $field;
        } else {
            $this->loginFailed();
        }
        
	}

    // Validator Login 
    private function validator(Request $request)
    {
        return Validator::make($request->all(), [
                $this->username() => 'required|string|exists:dns_donaturs',
                'password' => 'required|string|',
            ], [
                'required' => ':attribute wajib diisi',
                $this->username() . '.exists' => 'User tidak terdaftar!',
            ]);
    }

	protected function sendLoginResponse(Request $request)
	{
		$request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
	}

	protected function authenticated(Request $request, $user)
	{
		//
	}

	private function loginFailed()
	{
		return redirect()
			->back()
			->withInput()
			->with('error', 'Login gagal, email atau password salah!');
    }
    

	protected function guard()
	{
        return Auth::guard('member');
    }
    
    public function logout(Request $request)
	{
		$this->guard()->logout();

        $this->flushSession('members');

		if ($response = $this->loggedOut($request)) {
			return $response;
		}

		return redirect()->route('auth-user.login')->with('status', 'Anda telah keluar!');
	}

	protected function loggedOut(Request $request)
	{
		//
	}

    public function sendWa($phone, $message)
    {
        // $token = 'CFQLCwiaoLBAjT2Bd4cDQVN5ur6PLLoRKZeovMN7yRtBsjpi9k';
        $token = Config::get('app.tokenWA');
        $url = 'https://app.mesinwa.com/api/send-message.php';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT,30);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, array(
            'token'     => $token,
            'phone'     => $phone,
            'message'   => $message,
        ));
        $response = curl_exec($curl);
        curl_close($curl);
    }


}
