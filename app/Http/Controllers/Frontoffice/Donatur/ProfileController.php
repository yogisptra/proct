<?php

namespace App\Http\Controllers\Frontoffice\Donatur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DigiBase\Controller\BaseController;
use App\Repositories\DonaturRepository;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProfileController extends BaseController
{
    protected $repository;

    /**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(DonaturRepository $repository)
	{
        $this->repository = $repository;
	}

    public function index(Request $request)
    {
        try { 
            $country = $this->repository->getCountry();
            $province = $this->repository->getProvince();
            $city = $this->repository->getCity();
            $title = "Pengaturan";

            return $this->makeView('frontoffice.donatur.setting', compact('title', 'country', 'province', 'city'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    public function editProfile(Request $request, $id)
    {
        try {
            $data = $this->repository->show($id);
            $request['id'] = $data->id;

            $validator = $this->validator($request);
            
			if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
            if (!empty($request->file('image'))) {
				if (\File::exists(public_path('/assets/images/donatur' . $request->image))) {
                    \File::delete(public_path('/assets/images/donatur' . $request->image));
				}
				$image = time() . '.' .$request->file('image')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/images/donatur');
				$request->file('image')->move($destinationPath, $image);

			}

			if(empty($request->file('image'))) {
				$data = $this->repository->show($id);
				$request['image'] = $data->image;
			}
			$data = $this->repository->updateDonatur($request, $id);

            if ($data != true) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }
            return redirect()->route('dashboard-users')->with('success', 'Berhasil merubah data');
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    public function editAddress(Request $request, $id)
    {
        try {
            $request['id'] = $this->repository->getDonaturById($id);

            $data = $this->repository->updateAddressDonatur($request, $id);

            if (!$data) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }
            return redirect()->back()->with('success', 'Berhasil Merubah data');
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    public function editPassword(Request $request, $id)
    {
        try {
            $request['active'] = 'active';
            $request['id'] = $this->repository->show($id);
            $password = $request['id']['password'];

            if($request->passwordBaru != $request->passwordConfirm) {
                return redirect()->back()->with('error', 'Password Tidak Sesuai!');
            }

            if (!(Hash::check($request->input('passwordLama'), $request['id']['password']))) {
                return redirect()->back()->with('error', 'Password Lama Tidak Sesuai!');
            }
            $data = $this->repository->updatePasswordDonatur($request, $id);

            if (!$data) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }
            return redirect()->back()->with('success', 'Kata sandi berhasil diubah');
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    private function validator(Request $request)
	{
		return Validator::make($request->all(), [
                'name' 			=> 'required',
                'email'        => 'required|email|unique:dns_donaturs,email,'.$request->id,
                'phone_number' => 'required|regex:([0-9])|min:10|max:14|unique:dns_donaturs,phone_number,'.$request->id,
                'province_id' 	=> 'required',
                'city_id' 	    => 'required',
                'district_id' 	=> 'required',
                'area_id'    	=> 'required',
                // 'codepos'    	=> 'required',
                'image'     => 'image|mimes:jpg,png|max:5000'
            ],[
				'name.required' => ':attribute Wajib Diisi',
                'email.required' 			=> ':attribute Wajib Diisi',
                'email.max'		 			=> ':attribute Melebihi :max Karakter',
                'email.unique'				=> ':attribute Sudah Terdaftar',
                'email.email'				=> 'Format Penulisan :attribute Salah',
                'phone_number.required' 	=> ':attribute Wajib Diisi',
                'phone_number.max' 	 		=> ':attribute Maksimal :max Digit',
                'phone_number.min' 	 		=> ':attribute Minimal :min Digit',
                'phone_number.regex'	 	=> 'Format Penulisan :attribute Salah',
                'phone_number.unique'	 	=> ':attribute Sudah Terdaftar',
                'province_id.required' => ':attribute Wajib Diisi',
                'city_id.required' => ':attribute Wajib Diisi',
                'area_id.required' => ':attribute Wajib Diisi',
                'district_id.required' => ':attribute Wajib Diisi',
                // 'codepos.required' => ':attribute Wajib Diisi',
                'image.mimes'	 => 'Format :attribute Harus jpg,png',
			    'image.max'	     => ':attribute Maksimal :max Kb',
                
			],[
				'name' => 'Nama',
                'email' => 'Email',
                'phone_number' => 'Provinsi',
                'province_id' => 'Provinsi',
                'city_id'   => 'Kota/Kabupaten',
                'district_id' => 'Kecamatan',
                'area_id'   => 'Kelurahan',
                // 'codepos'   => 'Kode POS',
                'image' => 'Foto',
			]);
	}

    private function validatePasswordForm($request)
    {
        if ($request == NULL)
            return false;

        $data = [
            'passwordLama' => $request->input('passwordLama'),
            'passwordBaru' => $request->input('passwordBaru'),
            'passwordConfirm' => $request->input('passwordConfirm'),
        ];

        $rules = [
            'passwordLama'  => 'required',
            'passwordBaru' => 'min:3|required_with:passwordConfirm|same:passwordConfirm',
            'passwordConfirm' => 'required|min:3',
        ];

        $messages = [];

        $attributes = [
            'passwordLama' => 'Password Lama',
            'passwordBaru' => 'Password Baru',
            'passwordConfirm' => 'Ulangi Password',
        ];

        $validator = Validator::make($data, $rules, $messages, $attributes);

        if ($validator->fails()) $this->AssignValidatorToModelState($validator);
        return $validator->passes();
    }

    public function getCity($id)
    {
        try {
            $data = $this->repository->getCityByProvince($id);

            return response()->json($data);
        } catch(\Exception $exc){
            return $this->goTo500Page($exc);
        }
    }

    public function getDistrict($id)
    {
        try {
            $data = $this->repository->getDistrictByCity($id);

            return response()->json($data);
        } catch(\Exception $exc){
            return $this->goTo500Page($exc);
        }
    }

    public function getArea($id)
    {
        try {
            $data = $this->repository->getAreaByDistrict($id);

            return response()->json($data);
        } catch(\Exception $exc){
            return $this->goTo500Page($exc);
        }
    }
}
