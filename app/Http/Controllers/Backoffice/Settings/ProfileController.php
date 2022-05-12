<?php
namespace App\Http\Controllers\Backoffice\Settings;
use Illuminate\Http\Request;
use App\Http\Requests\SysUserRequest;
use App\DigiBase\Controller\BaseController;
use App\Models\User;
use App\Models\ModelHasRole;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Repositories\SysUserRepository;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Arr;

class ProfileController extends BaseController
{

	protected $repository;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(SysUserRepository $repository)
	{
        $this->repository = $repository;
	}
	/**
	* Display the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function show($id)
	{
        try {
			$id = $this->decodeHash($id);
			$user = $this->repository->show($id);
			return $this->makeView('backoffice.settings.users.profile.index', compact('user'));
		} catch (\Exception $exc) {
			 return $this->goTo500Page($exc);
        }
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit($id)
	{
       try {
			$id = $this->decodeHash($id);
            $user = $this->repository->show($id);
            if (!$user->exists) {
                return redirect()->route('sysprofile.edit')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return $this->makeView('backoffice.settings.users.profile.edit', compact('user'));
        } catch (\Exception $exc) {
             return $this->goTo500Page($exc);
        }
	}

	/**
	* Update the specified resource in storage.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function update(SysUserRequest $request, $id)
	{
       	try {
			$user = $this->repository->show($id);
			$request['id'] = $id;
			$request['password'] = $user->password;

			if (!empty($request->file('image'))) {
				if (\File::exists(public_path('/assets/images/admin' . $request->image))) {
                    \File::delete(public_path('/assets/images/admin' . $request->image));
				}
				$image = time() . '.' .$request->file('image')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/images/admin');
				$request->file('image')->move($destinationPath, $image);
		
			} 

			if(empty($request->file('image'))) {
				$user = $this->repository->show($id);
				$request['image'] = $user->image;
			}

			$user = $this->repository->update($id, $request);
		 	if ($user->errorInfo != null) {
		 		return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
			}
			return redirect()->route('home')->with('success', 'Profile Berhasil diubah');

        } catch (\Exception $exc) {
			//dd($exc);
             return $this->goTo500Page($exc);
        }
	}

	public function changePassword($id)
	{
		try {
			$id = $this->decodeHash($id);
			// $id = $this->decodeHash($id);
			$user = $this->repository->show($id);
			return $this->makeView('backoffice.settings.users.profile.reset_password', compact('user'));
        } catch (\Exception $exc) {
             return $this->goTo500Page($exc);
        }
	}

	public function updatePassword(Request $request, $id)
	{
		$validator = Validator::make($request->all(), [
			'password' => 'required|min:3|same:confirm_password',
			'confirm_password' => 'required',
		]);

		
		try {
			if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
			
			$request['id'] = $id;

			$update = $this->repository->updatePassword($request);
			
			return redirect()->back()->with('success', 'Password Berhasil diubah');
		} catch (\Exception $exc) {
			return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
		}
	}

}