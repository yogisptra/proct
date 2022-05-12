<?php

namespace App\Http\Controllers\Backoffice\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Carbon;
use App\Repositories\PasswordRessetRepository;
use App\Mail\ForgotPassword;

class ForgotPasswordController extends Controller
{
	protected $repository;

	function __construct(PasswordRessetRepository $repository)
	{
        $this->repository = $repository;
	}

	public function getEmail()
	{
       	try {
			$title = 'Forgot Password Page';
			return view('backoffice.auth.forgot_password', compact('title'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
	}

	public function activatedUser($token)
	{
		try {
			$checkToken = $this->repository->getByToken($token);
			if (empty($checkToken)) return redirect()->back()->with("error", "Token tidak ditemukan !");

			$verified = User::where('email', $checkToken->email)->update(['email_verified_at' => \Carbon\Carbon::now(), 'enabled' => 1]);
			// dd($verified);
			if (empty($verified)) {
				return redirect()->route('sysadmin.auth')->with('error', 'Terjadi kesalahan hubungi administrator');
			}

			if(isset($verified)) {
				$this->repository->deleteToken($checkToken->email);
			}
			
			return redirect()->route('sysadmin.auth')->with('success', 'Admin Berhasil diaktivasi');
		} catch (\Exception $exc) {
			dd($exc);
			return redirect()->route('sysadmin.auth')->with('error', 'Terjadi kesalahan hubungi administrator');
		}
	}

	public function sendEmail(Request $request)
	{
       	try {
			$checkEmail = User::where('email', $request->email)->first();
			if (empty($checkEmail)) {
				return redirect()->back()->with('error', 'Email Tidak Terdaftar');
			} elseif ($checkEmail->enabled != 1) {
				return redirect()->back()->with('error', 'Akun anda tidak aktif, pengajuan di reject / akun di blokir');
			} else {
				$request['name'] = $checkEmail->name;
				$storeToken = $this->repository->store($request);
				if(isset($storeToken)){
					$token = $this->repository->getByEmail($request->email);
					Mail::to($request->email)->send(new ForgotPassword($token));
					return back()->with('success', 'Link Reset Email sudah dikirim');
				}
			}
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
	}

	public function editPassword($token)
	{
       	try {
			$title = 'Forgot Password Page';
			$data = $this->repository->getByToken($token);
			// dd($data);
			return view('backoffice.auth.reset_password', compact('title', 'data'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
	}

	public function updatePassword(Request $request)
	{
       	try {
			$validator = Validator::make($request->all(), [
				'password' => 'required|min:3',
				'confirm_password' => 'required|same:password',
			]);
			// $request->validate([
			// 	'password' => 'required|min:3',
			// 	'confirm_password' => 'required|same:password',
			// ]);
			if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
			$checkToken = $this->repository->getByToken($request->token);

			if (empty($checkToken)) {
				return redirect()->back()->withInput()->with('error', 'Invalid token!');
			}

			$update = $this->repository->updatePassword($request);
			if(isset($update)) {
				$this->repository->deleteToken($request->email);
			}

			return redirect()->route('sysadmin.auth')->with('success', 'Password anda berhasil diubah!');
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }

	}

}