<?php

namespace App\Http\Controllers\Frontoffice\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\DigiBase\Controller\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendMailForgotPasswordJob;
use App\Models\Donatur;
use Carbon, Config;
use App\Repositories\PasswordRessetRepository;
use App\Repositories\DonaturRepository;
use App\Mail\ForgotPasswordUser;

class ForgotPasswordController extends BaseController
{
	protected $repository, $userRepository;

	function __construct(PasswordRessetRepository $repository, DonaturRepository $userRepository)
	{
        $this->repository = $repository;
        $this->userRepository = $userRepository;
	}

    public function formPassword()
	{
       	try {
			$title = 'Lupa Password';

			return view('frontoffice.auth.forgot_password', compact('title'));
        } catch (\Exception $exc) {
           return $this->goTo500Page($exc);
        }
	}

	public function activatedUser($token)
	{
		try {
			$checkToken = $this->repository->getByToken($token);
			if (empty($checkToken)) return redirect()->back()->with("error", "Token tidak ditemukan !");

			$verified = Donatur::where('email', $checkToken->email)->update(['email_verified' => 1, 'activated' => 1]);
			if (empty($verified)) {
				return redirect()->route('auth-user.login')->with('error', 'Terjadi kesalahan hubungi administrator');
			}

			if(isset($verified)) {
				$this->repository->deleteToken($checkToken->email);
			}
			
			return redirect()->route('auth-user.login')->with('success', 'Akun Berhasil diaktivasi');
		} catch (\Exception $exc) {
			return redirect()->route('auth-user.login')->with('error', 'Terjadi kesalahan hubungi administrator');
		}
	}

	public function sendEmail(Request $request)
	{
       	try {
			if(is_numeric($request->get('email'))){
                $checkEmail = $this->repository->getByUserPhone($request->email);
				$request['phone_number'] = $request->get('email');
				$request['email'] = NULL;
				if (empty($checkEmail)) {
					return redirect()->back()->with('error', 'Email/Nomor Telepon tidak terdaftar');
				} elseif ($checkEmail->activated != 1) {
					return redirect()->back()->with('error', 'Akun anda tidak aktif, pengajuan di reject / akun di blokir');
				} else {
					$request['name'] = $checkEmail->name;
					$storeToken = $this->repository->store($request);
					if(isset($storeToken)){
						$checkEmail->update([
							'otp' =>  $this->generateNumeric(6),
						]);
						$phone = $checkEmail->phone_number;
						$message = 'Hi, Kak '.$checkEmail['name'].',
									
Kode OTP Kakak adalah :
◾ Kode OTP: '.$checkEmail->otp.'
◾ Catatan : Jangan beritahu OTP ini ke siapapun, segala tindak kejahatan bukan tanggung jawab kami, Terimakasih.
						';
	
						$this->sendWa($phone, $message);
						$token = $this->repository->getByPhone($request['phone_number']);
						return redirect()->route('auth-user.editPassword', $token->token);
					} else {
						return back()->with('error', 'Email/Nomor Telepon tidak terdaftar');
					}
				}
				
            } elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
                $checkEmail = $this->repository->getByUserEmail($request->email);
				$request['email'] = $request->get('email');
				$request['phone_number'] = NULL;

				if (empty($checkEmail)) {
					return redirect()->back()->with('error', 'Email/Nomor Telepon tidak terdaftar');
				} elseif ($checkEmail->activated != 1) {
					return redirect()->back()->with('error', 'Akun anda tidak aktif, pengajuan di reject / akun di blokir');
				} else {
					$request['name'] = $checkEmail->name;
					$storeToken = $this->repository->store($request);
					if(isset($storeToken)){
						$checkEmail->update([
							'otp' =>  $this->generateNumeric(6),
						]);
						$token = $this->repository->getByEmail($request->email);
						// Mail::to($request->email)->send(new ForgotPasswordUser($token, $checkEmail));
						SendMailForgotPasswordJob::dispatch($token)
                        			->delay(now()->addSeconds(5));
						
						return redirect()->route('auth-user.editPassword', $token->token);
					} else {
						return back()->with('error', 'Email/Nomor Telepon tidak terdaftar');
					}
				}
            }
			
        } catch (\Exception $exc) {
           return $this->goTo500Page($exc);
        }
	}

	public function editPasswordOtp($token)
	{
       	try {
			$title = 'Lupa Password';
			$data = $this->repository->getByToken($token);

			return view('frontoffice.auth.reset-password-otp', compact('title', 'data'));
        } catch (\Exception $exc) {
           return $this->goTo500Page($exc);
        }
	}

    public function confirmationOTP(Request $request, $id)
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

            $checkToken = $this->repository->getByToken($request->token);

	        if (empty($checkToken)) {
				return redirect()->back()->withInput()->with('error', 'Invalid token!');
			}

            $data = $this->userRepository->show($id);
            if($data->otp == $dataOtp){
                $verified = $this->userRepository->updateAktifasiDonatur($data->email);
                return redirect()->route('auth-user.editFormPassword', ['id' => $this->encodeHash($data->id)]);
            }else{
                return redirect()->back()->with('error', 'Konfirmasi gagal dikarenakan OTP yang anda masukan tidak sesuai');
            }
            
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    public function editPassword($id)
    {
        $title = 'Lupa Password';
        $id = $this->decodeHash($id);
        $data = $this->userRepository->show($id);

        return view('frontoffice.auth.reset-password', compact('title', 'data'));
    }

	public function updatePassword(Request $request)
	{
       	try {
			$validator = Validator::make($request->all(), [
				'password' => 'required|min:3',
				'confirm_password' => 'required|same:password',
			]);
			if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

			$update = $this->repository->updatePassword($request);
            
			if(isset($update)) {
				$this->repository->deleteToken($request->email);
			}

			return redirect()->route('auth-user.login')->with('success', 'Password anda berhasil diubah!');
        } catch (\Exception $exc) {
           return $this->goTo500Page($exc);
        }

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