<?php

namespace App\Http\Controllers\Frontoffice\Donatur;

use App\Http\Controllers\Controller;
use App\DigiBase\Controller\BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Repositories\DonaturRepository;
use App\Repositories\BankAccountRepository;
use App\Repositories\LandingPageRepository;
use Auth, PDF;

class CampaignerController extends BaseController
{
    protected $repository, $bankRepository, $landingRepository;

    /**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(DonaturRepository $repository, BankAccountRepository $bankRepository, LandingPageRepository $landingRepository)
	{
        $this->repository = $repository;
        $this->bankRepository = $bankRepository;
        $this->landingRepository = $landingRepository;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $title = "Jadi Campaigner";

            return $this->makeView('frontoffice.campaigner.index', compact('title'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function terms($type)
    {
        try {
            $title = "Jadi Campaigner";
            if($type == 'PERSONAL') {
                $term = $this->landingRepository->getTermCampaignerPersonal();
                return $this->makeView('frontoffice.campaigner.terms', compact('title', 'type', 'term'));
            } else {
                $term = $this->landingRepository->getTermCampaignerCorporate();
                return $this->makeView('frontoffice.campaigner.terms', compact('title', 'type', 'term'));
            }
            
            
          
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    public function onBoardRegCampaigner($type)
    {
        try {
            $country = $this->repository->getCountry();
            $province = $this->repository->getProvince();
            $city = $this->repository->getCity();
            $district = $this->repository->getDistrict();
            $typeCorporate = $this->repository->getTipeCorporate();

            if($type == 'PERSONAL') {
                $title = "Sebagai Perorangan";
               
                return $this->makeView('frontoffice.campaigner.registrasiPersonal', compact('title', 'country', 'type', 'province', 'city', 'district'));
            } else {
                $title = "Sebagai Perusahaan";

                return $this->makeView('frontoffice.campaigner.registrasiCorporate', compact('title', 'country', 'type', 'province', 'city', 'district', 'typeCorporate'));
            }
           
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    public function storeRegisterCampaigner(Request $request)
    {
        try {
            $validator = $this->validator($request);

			if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

            if (!empty($request->file('image_ktp'))) {
                $data = $this->repository->show(Auth::guard('member')->user()->id);
                if (\File::exists(public_path('/assets/images/donatur/ktp' . $data->image_ktp))) {
                    \File::delete(public_path('/assets/images/donatur/ktp' . $data->image_ktp));
                }
                $image_ktp = time() . '.' .$request->file('image_ktp')->getClientOriginalExtension();
                $destinationPath = public_path('/assets/image_ktp/donatur/ktp');
                $request->file('image_ktp')->move($destinationPath, $image_ktp);
            }

            if(empty($request->file('image_ktp'))) {
                $data = $this->repository->show(Auth::guard('member')->user()->id);
                $request['image_ktp'] = $data->image_ktp;
            }

            if (!empty($request->file('image_selfie'))) {
                $data = $this->repository->show(Auth::guard('member')->user()->id);
                if (\File::exists(public_path('/assets/images/donatur/ktp' . $data->image_selfie))) {
                    \File::delete(public_path('/assets/images/donatur/ktp' . $data->image_selfie));
                }
                $image_selfie = time() . '.' .$request->file('image_selfie')->getClientOriginalExtension();
                $destinationPath = public_path('/assets/image_selfie/donatur/ktp');
                $request->file('image_selfie')->move($destinationPath, $image_selfie);
            }

            if(empty($request->file('image_selfie'))) {
                $data = $this->repository->show(Auth::guard('member')->user()->id);
                $request['image_selfie'] = $data->image_selfie;
            }  

            if($request->snk == 1) {
                $request['is_campaigner'] = 'UNVERIFIED';

                $data = $this->repository->registCampaigner($request, Auth::guard('member')->user()->id);

                if ($data != true) {
                    return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
                }

                return redirect()->route('success-pageCampaigner');
            } else {
                return redirect()->back()->with('error', 'Harap setujui ketentuan yang sudah tertera!') ;
            }
            
        } catch(\Exception $exc){
            return $this->goTo500Page($exc);
        }
    }

    public function storeRegisterCorporateCampaigner(Request $request)
    {
        try {
            $validator = $this->validatorCorporate($request);

			if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
            // Corporate
            if (!empty($request->file('image'))) {
				if (\File::exists(public_path('/assets/images/corporate' . $request->image))) {
                    \File::delete(public_path('/assets/images/corporate' . $request->image));
				}
				$image = time() . '.' .$request->file('image')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/images/corporate');
				$request->file('image')->move($destinationPath, $image);
			}

            if (!empty($request->file('file_akta'))) {
				if (\File::exists(public_path('/assets/file_akta/corporate' . $request->file_akta))) {
                    \File::delete(public_path('/assets/file_akta/corporate' . $request->file_akta));
				}
				$file_akta = time() . '.' .$request->file('file_akta')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/file_akta/corporate');
				$request->file('file_akta')->move($destinationPath, $file_akta);
			}

            if (!empty($request->file('nib'))) {
				if (\File::exists(public_path('/assets/nib/corporate' . $request->nib))) {
                    \File::delete(public_path('/assets/nib/corporate' . $request->nib));
				}
				$nib = time() . '.' .$request->file('nib')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/nib/corporate');
				$request->file('nib')->move($destinationPath, $nib);
			}

            if (!empty($request->file('ktp_pic'))) {
				if (\File::exists(public_path('/assets/pic/ktp' . $request->ktp_pic))) {
                    \File::delete(public_path('/assets/pic/ktp' . $request->ktp_pic));
				}
				$ktp_pic = time() . '.' .$request->file('ktp_pic')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/pic/ktp');
				$request->file('ktp_pic')->move($destinationPath, $ktp_pic);
			}

            if (!empty($request->file('image_selfie_pic'))) {
				if (\File::exists(public_path('/assets/pic/images' . $request->image_selfie_pic))) {
                    \File::delete(public_path('/assets/pic/images' . $request->image_selfie_pic));
				}
				$image_selfie_pic = time() . '.' .$request->file('image_selfie_pic')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/pic/images');
				$request->file('image_selfie_pic')->move($destinationPath, $image_selfie_pic);
			}

            if($request->snk == 1) {
                $request['is_campaigner'] = 'UNVERIFIED';
                $request['id'] = $this->GenerateAutoNumber('dns_corporate_details');
                $request['user_id'] = Auth::guard('member')->user()->id;

                $data = $this->repository->registCampaignerCorporate($request);
            } else {
                return redirect()->back()->with('error', 'Harap setujui ketentuan yang sudah tertera!') ;
            }
            
        } catch(\Exception $exc){
            return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
        }
        return redirect()->route('success-pageCampaigner');
    }


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pageSuccess()
    {
        try {
            $title = 'Pendaftaran Berhasil';

            return $this->makeView('frontoffice.campaigner.info-register', compact('title'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pageBank()
    {
        try {
            $title = 'Rekening Pencairan';
            $data = $this->bankRepository->getBankCampaigner();

            return $this->makeView('frontoffice.campaigner.bank.index', compact('title', 'data'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createBank()
    {
        try {
            $title = 'Tambah Rekening';
            $bank = $this->bankRepository->getBank();

            return $this->makeView('frontoffice.campaigner.bank.form', compact('title', 'bank'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    
    public function storeBank(Request $request)
    {
        try {
            $validator = $this->validatorBank($request);

			if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

            $request['id'] = $this->GenerateAutoNumber('dns_bank_account_campaigners');
            $request['user_id'] = Auth::guard('member')->user()->id;

            $data = $this->bankRepository->storeBankCampaigner($request);
                
            // if ($data != true) {
            if ($data->errorInfo != null || !$data->exists) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            $title = 'Tambah Rekening Berhasil';

            return $this->makeView('frontoffice.campaigner.bank.info-success', compact('title'));
            
        } catch(\Exception $exc){
            return $this->goTo500Page($exc);
        }
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function editBank($id)
    {
        try {
            $id = $this->decodeHash($id);

            $title = 'Edit Rekening';
            $data = $this->bankRepository->showBankAccount($id);
            $bank = $this->bankRepository->getBank();

            return $this->makeView('frontoffice.campaigner.bank.form', compact('title', 'bank', 'data'));
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
    public function updateBank(Request $request, $id)
    {
        try {
            $request['id'] = $id;

			$data = $this->bankRepository->updateBankCampaigner($id, $request);

            if ($data->errorInfo != null || !$data->exists) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return redirect()->route('bank-campaigner');
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
    public function deleteBank($id)
    {
        try {
            $id = $this->decodeHash($id);

			$data = $this->bankRepository->deleteBankCampaigner($id);

            if (!$data) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return redirect()->route('bank-campaigner');
        } catch (\Exception $exc) {
             return $this->goTo500Page($exc);
        }
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


    private function validator(Request $request)
	{
		return Validator::make($request->all(), [
                'nik'           => 'required|max:20|unique:dns_donaturs,nik,'.$request->id,
                'name' 			=> 'required',
                'address' 		=> 'required',
                'province_id' 	=> 'required',
                'city_id' 	    => 'required',
                'district_id' 	=> 'required',
                'area_id'    	=> 'required',
                'codepos'    	=> 'required',
                'image_ktp'     => 'required|image|mimes:jpg,png|max:1000',
                'image_selfie'  => 'required|image|mimes:jpg,png|max:1000',
            ],[
				'name.required' => ':attribute Wajib Diisi',
                'nik.required' => ':attribute Wajib Diisi',
                'nik.max'		=> ':attribute Melebihi :max Karakter',
                'nik.unique'		=> ':attribute Sudah Terdaftar',
                'address.required' => ':attribute Wajib Diisi',
                'province_id.required' => ':attribute Wajib Diisi',
                'city_id.required' => ':attribute Wajib Diisi',
                'area_id.required' => ':attribute Wajib Diisi',
                'district_id.required' => ':attribute Wajib Diisi',
                'codepos.required' => ':attribute Wajib Diisi',
                'image_ktp.required' => ':attribute Wajib Diisi',
                'image_ktp.mimes'	 => 'Format :attribute Harus jpg,png',
			    'image_ktp.max'	     => ':attribute Maksimal :max Kb',
                'image_selfie.required' => ':attribute Wajib Diisi',
                'image_selfie.mimes'	 => 'Format :attribute Harus jpg,png',
			    'image_selfie.max'	     => ':attribute Maksimal :max Kb',
                
			],[
				'name' => 'Nama',
                'nik' => 'NIK',
                'address' => 'Alamat',
                'province_id' => 'Provinsi',
                'city_id'   => 'Kota/Kabupaten',
                'district_id' => 'Kecamatan',
                'area_id'   => 'Kelurahan',
                'codepos'   => 'Kode POS',
                'image_ktp' => 'Foto KTP',
                'image_selfie' => 'Foto Selfie KTP',
			]);
	}


    private function validatorCorporate(Request $request)
	{
		return Validator::make($request->all(), [
                // Corporate
                'type_corporate'=> 'required',
                'corporate_name'=> 'required',
                'corporate_email'=> 'required',
                'corporate_phone_number'=> 'required',
                'corporate_address'=> 'required',
                'corporate_province'=> 'required',
                'corporate_city' => 'required',
                'corporate_district' => 'required',
                'corporate_area' => 'required',
                'corporate_codepos'=> 'required|max:7',
                'file_akta' => 'required|image|mimes:jpg,png|max:1000',
                'image' => 'required|image|mimes:jpg,png|max:1000',
                'nik_pic'           => 'required|max:20|unique:dns_corporate_details,nik_pic,'.$request->id,
                'name_pic' 			=> 'required',
                'email_pic' 	=> 'required',
                'phone_number_pic' 	    => 'required',
                'ktp_pic'     => 'required|image|mimes:jpg,png|max:1000',
                'image_selfie_pic'  => 'required|image|mimes:jpg,png|max:1000',
                'nib'  => 'image|mimes:jpg,png|max:1000',
            ],[
                // Corporate
                'type_corporate.required' => ':attribute Wajib Diisi',
                'corporate_name.required' => ':attribute Wajib Diisi',
                'corporate_email.required' => ':attribute Wajib Diisi',
                'corporate_phone_number.required' => ':attribute Wajib Diisi',
                'corporate_address.required' => ':attribute Wajib Diisi',
                'corporate_province.required' => ':attribute Wajib Diisi',
                'corporate_city.required' => ':attribute Wajib Diisi',
                'corporate_district.required' => ':attribute Wajib Diisi',
                'corporate_area.required' => ':attribute Wajib Diisi',
                'corporate_codepos.required' => ':attribute Wajib Diisi',
                'corporate_codepos.max'		=> ':attribute Melebihi :max Karakter',
                'file_akta.required' => ':attribute Wajib Diisi',
                'file_akta.mimes'	 => 'Format :attribute Harus jpg,png',
			    'file_akta.max'	     => ':attribute Maksimal :max Kb',
                'image.required' => ':attribute Wajib Diisi',
                'image.mimes'	 => 'Format :attribute Harus jpg,png',
			    'image.max'	     => ':attribute Maksimal :max Kb',
				'name_pic.required' => ':attribute Wajib Diisi',
                'nik_pic.required' => ':attribute Wajib Diisi',
                'nik_pic.max'		=> ':attribute Melebihi :max Karakter',
                'nik_pic.unique'		=> ':attribute Sudah Terdaftar',
                'email_pic.required' => ':attribute Wajib Diisi',
                'phone_number_pic.required' => ':attribute Wajib Diisi',
                'ktp_pic.required' => ':attribute Wajib Diisi',
                'ktp_pic.mimes'	 => 'Format :attribute Harus jpg,png',
			    'ktp_pic.max'	     => ':attribute Maksimal :max Kb',
                'image_selfie_pic.required' => ':attribute Wajib Diisi',
                'image_selfie_pic.mimes'	 => 'Format :attribute Harus jpg,png',
			    'image_selfie_pic.max'	     => ':attribute Maksimal :max Kb',
                'nib.mimes'	 => 'Format :attribute Harus jpg,png',
			    'nib.max'	     => ':attribute Maksimal :max Kb',
			],[
                'nib' => 'NIB',
                'type_corporate.required' => 'Jenis Lembaga',
                'corporate_name' => 'Nama Perusahaan/Yayasan',
                'corporate_email' => 'Email Perusahaan/Yayasan',
                'corporate_phone_number' => 'Nomor Telepon Perusahaan/Yayasan',
                'corporate_address' => 'Alamat Perusahaan',
                'corporate_province' => 'Provinsi',
                'corporate_city'   => 'Kota/Kabupaten',
                'corporate_district' => 'Kecamatan',
                'corporate_area'   => 'Kelurahan',
                'corporate_codepos'   => 'Kode POS',
                'file_akta'   => 'File',
                'image'   => 'Logo',
				'name_pic' => 'Nama',
                'nik_pic' => 'NIK',
                'email_pic' => 'Email',
                'phone_number_pic' => 'Nomor Telepon',
                'ktp_pic' => 'Foto KTP',
                'image_selfie_pic' => 'Foto Selfie KTP',
			]);
	}

    private function validatorBank(Request $request)
	{
		return Validator::make($request->all(), [
                'account_name' => 'required',
                'account_number' => 'required|regex:([0-9])|unique:dns_bank_account_campaigners,account_number,'.$request->id,
                'bank_id' => 'required',
                'description' => 'required',
            ],[
				'account_name.required' => ':attribute Wajib Diisi',
                'account_number.required' => ':attribute Wajib Diisi',
                'account_number.regex'	 	=> 'Format Penulisan :attribute Salah, [0-9]',
                'account_number.unique'		=> ':attribute Sudah Terdaftar',
                'bank_id' => ':attribute Wajib Diisi',
                'description' => ':attribute Wajib Diisi',
			],[
				'account_name' => 'Nama Akun',
                'account_number' => 'Nomor Akun',
                'bank_id'   => 'Bank',
                'description' => 'Cabang',
                
			]);
	}
}
