<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use App\Models\Donatur;
use App\Models\Corporate;
use App\Models\SysCountry;
use App\Models\SysProvince;
use App\Models\SysCity;
use App\Models\SysDistrict;
use App\Models\SysArea;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\BankAccount;
use App\Models\CampaignList;
use App\Models\ProfileYayasan;
use App\Models\TypeCorporate;
use Illuminate\Http\Request;
use Hash, Str, DB, Auth, Cache;

class DonaturRepository extends Apprepository{
    protected $model, $corporate, $country, $province, $city, $district, $area, $transaction, $category, $bankAccount, $profileRepository, $typeCorporate;

    public function __construct(Donatur $model, Corporate $corporate, SysCountry $country, SysProvince $province, SysCity $city, SysDistrict $district, SysArea $area, Transaction $transaction, Category $category, BankAccount $bankAccount, ProfileYayasan $profileRepository, TypeCorporate $typeCorporate)
    {
        $this->model = $model;
        $this->corporate = $corporate;
        $this->country = $country;
        $this->province = $province;
        $this->city = $city;
        $this->district = $district;
        $this->area = $area;
        $this->transaction = $transaction;
        $this->category = $category;
        $this->bankAccount = $bankAccount;
        $this->profileRepository = $profileRepository;
        $this->typeCorporate = $typeCorporate;
    }

    protected function setDataPayload(Request $request)
    {
        if(!empty($request->file('image'))){
			$image = time() . '.' .$request->file('image')->getClientOriginalExtension();
		}else if (isset($request['image'])){
			$image = $request['image'];
		}else {
			$image = null;
		}

        if(!empty($request->file('image_ktp'))){
			$image_ktp = time() . '.' .$request->file('image_ktp')->getClientOriginalExtension();
		}else if (isset($request['image_ktp'])){
			$image_ktp = $request['image_ktp'];
		}else {
			$image_ktp = null;
		}

        if(!empty($request->file('image_selfie'))){
			$image_selfie = time() . '.' .$request->file('image_selfie')->getClientOriginalExtension();
		}else if (isset($request['image_selfie'])){
			$image_selfie = $request['image_selfie'];
		}else {
			$image_selfie = null;
		}

		if(isset($request['password'])){
			if(strlen($request['password']) > 20){
				$password = $request['password'];
			}else{
				$password = Hash::make($request['password']);
			}
		}else {
			$password = null;
		}

        return [
            'id' 			=> isset($request['id']) ? $request->input('id') : null,
            'name' 			=> isset($request['name']) ? $request->input('name') : null,
            'email' 		=> isset($request['email']) ? $request->input('email') : null,
            'password' 		=> $password,
            'phone_number' 	=> isset($request['phone_number']) ? $request->input('phone_number') : null,
            'nik' 	        => isset($request['nik']) ? $request->input('nik') : null,
            'gender' 		=> isset($request['gender']) ? $request->input('gender') : null,
            'birth_date' 	=> isset($request['birth_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('birth_date'))->format('Y-m-d') : null,
            'birth_place' 	=> isset($request['birth_place']) ? $request->input('birth_place') : null,
            'country_id' 	=> isset($request['country_id']) ? $request->input('country_id') : null,
            'province_id' 	=> isset($request['province_id']) ? $request->input('province_id') : null,
            'city_id' 	    => isset($request['city_id']) ? $request->input('city_id') : null,
            'district_id' 	=> isset($request['district_id']) ? $request->input('district_id') : null,
            'area_id' 	    => isset($request['area_id']) ? $request->input('area_id') : null,
            'code_pos' 	    => isset($request['code_pos']) ? $request->input('code_pos') : null,
            'address' 	    => isset($request['address']) ? $request->input('address') : null,
            'religion' 	    => isset($request['religion']) ? $request->input('religion') : null,
            'nationality' 	=> isset($request['nationality']) ? $request->input('nationality') : null,
            'bio' 	        => isset($request['bio']) ? $request->input('bio') : null,
            'is_campaigner' 	=> isset($request['is_campaigner']) ? $request->input('is_campaigner') : null,
            'type_campaigner' 	=> isset($request['type_campaigner']) ? $request->input('type_campaigner') : null,
            'image' 		=> $image,
            'image_ktp'     => $image_ktp,
            'image_selfie' 	=> $image_selfie,
            'slug_token' 	=> isset($request['slug_token']) ? $request->input('slug_token') : null,
            'activated' 	=> isset($request['activated']) ? $request->input('activated') : null,
            'otp' 	        => isset($request['otp']) ? $request->input('otp') : null,
            'remember_token'=> Str::random(60),
            'api_token'     => Str::random(60),
        ];
    }

    public function updateDonatur(Request $request, $id)
    {
        $data = $this->show($id);

        if(!empty($request->file('image'))){
			$image = time() . '.' .$request->file('image')->getClientOriginalExtension();
		}else if (isset($request['image'])){
			$image = $request['image'];
		}else {
			$image = null;
		}

        $data->update([
            'name' 			=> isset($request['name']) ? $request->input('name') : null,
            'email' 		=> isset($request['email']) ? $request->input('email') : null,
            'phone_number' 	=> isset($request['phone_number']) ? $request->input('phone_number') : null,
            'image' 		=> $image,
            'address' 	    => isset($request['address']) ? $request->input('address') : null,
            'country_id' 	=> isset($request['country_id']) ? $request->input('country_id') : null,
            'province_id' 	=> isset($request['province_id']) ? $request->input('province_id') : null,
            'city_id' 	    => isset($request['city_id']) ? $request->input('city_id') : null,
            'district_id' 	=> isset($request['district_id']) ? $request->input('district_id') : null,
            'area_id' 	    => isset($request['area_id']) ? $request->input('area_id') : null,
            'codepos' 	    => isset($request['codepos']) ? $request->input('codepos') : null,
            'facebook' => isset($request['facebook']) ? $request->input('facebook') : null,
            'instagram' => isset($request['instagram']) ? $request->input('instagram') : null,
            'twitter' => isset($request['twitter']) ? $request->input('twitter') : null,
            'linkedin' => isset($request['linkedin']) ? $request->input('linkedin') : null,
            'tiktok' => isset($request['tiktok']) ? $request->input('tiktok') : null,
            'bio' => isset($request['bio']) ? $request->input('bio') : null,
        ]);

        return $data;
        
    }

    public function registCampaigner(Request $request, $id)
    {
        $data = $this->show($id);

        if(!empty($request->file('image_ktp'))){
			$image_ktp = time() . '.' .$request->file('image_ktp')->getClientOriginalExtension();
		}else if (isset($request['image_ktp'])){
			$image_ktp = $request['image_ktp'];
		}else {
			$image_ktp = null;
		}

        if(!empty($request->file('image_selfie'))){
			$image_selfie = time() . '.' .$request->file('image_selfie')->getClientOriginalExtension();
		}else if (isset($request['image_selfie'])){
			$image_selfie = $request['image_selfie'];
		}else {
			$image_selfie = null;
		}

        return $data->update([
            'nik' 	        => isset($request['nik']) ? $request->input('nik') : null,
            'name' 			=> isset($request['name']) ? $request->input('name') : null,
            'country_id' 	=> isset($request['country_id']) ? $request->input('country_id') : null,
            'province_id' 	=> isset($request['province_id']) ? $request->input('province_id') : null,
            'city_id' 	    => isset($request['city_id']) ? $request->input('city_id') : null,
            'district_id' 	=> isset($request['district_id']) ? $request->input('district_id') : null,
            'area_id' 	    => isset($request['area_id']) ? $request->input('area_id') : null,
            'codepos' 	    => isset($request['codepos']) ? $request->input('codepos') : null,
            'address' 		=> isset($request['address']) ? $request->input('address') : null,
            'type_campaigner' => isset($request['type_campaigner']) ? $request->input('type_campaigner') : null,
            'is_campaigner' => isset($request['is_campaigner']) ? $request->input('is_campaigner') : null,
            'facebook' => isset($request['facebook']) ? $request->input('facebook') : null,
            'instagram' => isset($request['instagram']) ? $request->input('instagram') : null,
            'twitter' => isset($request['twitter']) ? $request->input('twitter') : null,
            'linkedin' => isset($request['linkedin']) ? $request->input('linkedin') : null,
            'tiktok' => isset($request['tiktok']) ? $request->input('tiktok') : null,
            'bio' => isset($request['bio']) ? $request->input('bio') : null,
            'image_ktp' 	=> $image_ktp,
            'image_selfie' 	=> $image_selfie,
        ]);
    }

    public function registCampaignerCorporate(Request $request) 
    {
        $data = NULL;
        DB::beginTransaction();
        try {

            if(!empty($request->file('nib'))){
                $nib = time() . '.' .$request->file('nib')->getClientOriginalExtension();
            }else if (isset($request['nib'])){
                $nib = $request['nib'];
            }else {
                $nib = null;
            }

            if(!empty($request->file('file_akta'))){
                $file_akta = time() . '.' .$request->file('file_akta')->getClientOriginalExtension();
            }else if (isset($request['file_akta'])){
                $file_akta = $request['file_akta'];
            }else {
                $file_akta = null;
            }
    
            if(!empty($request->file('image'))){
                $image = time() . '.' .$request->file('image')->getClientOriginalExtension();
            }else if (isset($request['image'])){
                $image = $request['image'];
            }else {
                $image = null;
            }

            if(!empty($request->file('ktp_pic'))){
                $ktp_pic = time() . '.' .$request->file('ktp_pic')->getClientOriginalExtension();
            }else if (isset($request['ktp_pic'])){
                $ktp_pic = $request['ktp_pic'];
            }else {
                $ktp_pic = null;
            }
    
            if(!empty($request->file('image_selfie_pic'))){
                $image_selfie_pic = time() . '.' .$request->file('image_selfie_pic')->getClientOriginalExtension();
            }else if (isset($request['image_selfie_pic'])){
                $image_selfie_pic = $request['image_selfie_pic'];
            }else {
                $image_selfie_pic = null;
            }

            $user = $this->model->findorFail(Auth::guard('member')->user()->id);

            $user->update([
                'is_campaigner' => 'UNVERIFIED',
                'type_campaigner' => isset($request['type_campaigner']) ? $request->input('type_campaigner') : null,
            ]);

            $data = $this->corporate->create([
                'id' => isset($request['id']) ? $request->input('id') : null,
                'type_corporate'  => isset($request['type_corporate']) ? $request->input('type_corporate') : null,
                'user_id'  => isset($request['user_id']) ? $request->input('user_id') : null,
                'corporate_name' => isset($request['corporate_name']) ? $request->input('corporate_name') : null,
                'corporate_email' => isset($request['corporate_email']) ? $request->input('corporate_email') : null,
                'corporate_phone_number' => isset($request['corporate_phone_number']) ? $request->input('corporate_phone_number') : null,
                'corporate_address' => isset($request['corporate_address']) ? $request->input('corporate_address') : null,
                'corporate_country' => isset($request['corporate_country']) ? $request->input('corporate_country') : null,
                'corporate_province' => isset($request['corporate_province']) ? $request->input('corporate_province') : null,
                'corporate_city' => isset($request['corporate_city']) ? $request->input('corporate_city') : null,
                'corporate_district' => isset($request['corporate_district']) ? $request->input('corporate_district') : null,
                'corporate_area' => isset($request['corporate_area']) ? $request->input('corporate_area') : null,
                'corporate_codepos' => isset($request['corporate_codepos']) ? $request->input('corporate_codepos') : null,
                'file_akta' => $file_akta,
                'image' => $image,
                'nik_pic' => isset($request['nik_pic']) ? $request->input('nik_pic') : null,
                'name_pic' => isset($request['name_pic']) ? $request->input('name_pic') : null,
                'email_pic' => isset($request['email_pic']) ? $request->input('email_pic') : null,
                'phone_number_pic' => isset($request['phone_number_pic']) ? $request->input('phone_number_pic') : null,
                'nib' => $nib,
                'ktp_pic' => $ktp_pic,
                'image_selfie_pic' => $image_selfie_pic,
                'facebook' => isset($request['facebook']) ? $request->input('facebook') : null,
                'instagram' => isset($request['instagram']) ? $request->input('instagram') : null,
                'twitter' => isset($request['twitter']) ? $request->input('twitter') : null,
                'linkedin' => isset($request['linkedin']) ? $request->input('linkedin') : null,
                'tiktok' => isset($request['tiktok']) ? $request->input('tiktok') : null,
                'bio' => isset($request['bio']) ? $request->input('bio') : null,
            ]);

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }

        return $data;
    }

    public function updateCampaignerPersonal(Request $request, $id)
    {
        $data = $this->show($id);

        if(!empty($request->file('image_ktp'))){
			$image_ktp = time() . '.' .$request->file('image_ktp')->getClientOriginalExtension();
		}else if (isset($request['image_ktp'])){
			$image_ktp = $request['image_ktp'];
		}else {
			$image_ktp = null;
		}

        if(!empty($request->file('image_selfie'))){
			$image_selfie = time() . '.' .$request->file('image_selfie')->getClientOriginalExtension();
		}else if (isset($request['image_selfie'])){
			$image_selfie = $request['image_selfie'];
		}else {
			$image_selfie = null;
		}

        return $data->update([
            'nik' 	        => isset($request['nik']) ? $request->input('nik') : null,
            'name' 			=> isset($request['name']) ? $request->input('name') : null,
            'email' 			=> isset($request['email']) ? $request->input('email') : null,
            'phone_number' 			=> isset($request['phone_number']) ? $request->input('phone_number') : null,
            'country_id' 	=> isset($request['country_id']) ? $request->input('country_id') : null,
            'province_id' 	=> isset($request['province_id']) ? $request->input('province_id') : null,
            'city_id' 	    => isset($request['city_id']) ? $request->input('city_id') : null,
            'district_id' 	=> isset($request['district_id']) ? $request->input('district_id') : null,
            'area_id' 	    => isset($request['area_id']) ? $request->input('area_id') : null,
            'codepos' 	    => isset($request['codepos']) ? $request->input('codepos') : null,
            'address' 		=> isset($request['address']) ? $request->input('address') : null,
            'image_ktp' 	=> $image_ktp,
            'image_selfie' 	=> $image_selfie,
        ]);
    }

    public function updateCampaignerCorporate(Request $request, $id) 
    {
        $data = NULL;
        DB::beginTransaction();
        try {

            if(!empty($request->file('file_akta'))){
                $file_akta = time() . '.' .$request->file('file_akta')->getClientOriginalExtension();
            }else if (isset($request['file_akta'])){
                $file_akta = $request['file_akta'];
            }else {
                $file_akta = null;
            }
    
            if(!empty($request->file('image'))){
                $image = time() . '.' .$request->file('image')->getClientOriginalExtension();
            }else if (isset($request['image'])){
                $image = $request['image'];
            }else {
                $image = null;
            }

            if(!empty($request->file('ktp_pic'))){
                $ktp_pic = time() . '.' .$request->file('ktp_pic')->getClientOriginalExtension();
            }else if (isset($request['ktp_pic'])){
                $ktp_pic = $request['ktp_pic'];
            }else {
                $ktp_pic = null;
            }
    
            if(!empty($request->file('image_selfie_pic'))){
                $image_selfie_pic = time() . '.' .$request->file('image_selfie_pic')->getClientOriginalExtension();
            }else if (isset($request['image_selfie_pic'])){
                $image_selfie_pic = $request['image_selfie_pic'];
            }else {
                $image_selfie_pic = null;
            }

            $data = $this->corporate->findorFail($id);

            $data->update([
                'nib' => isset($request['nib']) ? $request->input('nib') : null,
                'corporate_name' => isset($request['corporate_name']) ? $request->input('corporate_name') : null,
                'corporate_email' => isset($request['corporate_email']) ? $request->input('corporate_email') : null,
                'corporate_phone_number' => isset($request['corporate_phone_number']) ? $request->input('corporate_phone_number') : null,
                'corporate_address' => isset($request['corporate_address']) ? $request->input('corporate_address') : null,
                'corporate_province' => isset($request['corporate_province']) ? $request->input('corporate_province') : null,
                'corporate_city' => isset($request['corporate_city']) ? $request->input('corporate_city') : null,
                'corporate_district' => isset($request['corporate_district']) ? $request->input('corporate_district') : null,
                'corporate_area' => isset($request['corporate_area']) ? $request->input('corporate_area') : null,
                'corporate_codepos' => isset($request['corporate_codepos']) ? $request->input('corporate_codepos') : null,
                'file_akta' => $file_akta,
                'image' => $image,
                'nik_pic' => isset($request['nik_pic']) ? $request->input('nik_pic') : null,
                'name_pic' => isset($request['name_pic']) ? $request->input('name_pic') : null,
                'email_pic' => isset($request['email_pic']) ? $request->input('email_pic') : null,
                'phone_number_pic' => isset($request['phone_number_pic']) ? $request->input('phone_number_pic') : null,
                'ktp_pic' => $ktp_pic,
                'image_selfie_pic' => $image_selfie_pic,
                'facebook' => isset($request['facebook']) ? $request->input('facebook') : null,
                'instagram' => isset($request['instagram']) ? $request->input('instagram') : null,
                'twitter' => isset($request['twitter']) ? $request->input('twitter') : null,
                'linkedin' => isset($request['linkedin']) ? $request->input('linkedin') : null,
                'tiktok' => isset($request['tiktok']) ? $request->input('tiktok') : null,
                'bio' => isset($request['bio']) ? $request->input('bio') : null,
            ]);

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }

        return $data;
    }

    public function updateAddressDonatur(Request $request, $id)
    {
        $data = $this->getDonaturById($id);

        return $data->update([
            'country_id' 	=> isset($request['country_id']) ? $request->input('country_id') : null,
            'province_id' 	=> isset($request['province_id']) ? $request->input('province_id') : null,
            'city_id' 	    => isset($request['city_id']) ? $request->input('city_id') : null,
            'district_id' 	=> isset($request['district_id']) ? $request->input('district_id') : null,
            'area_id' 	    => isset($request['area_id']) ? $request->input('area_id') : null,
            'address' 	    => isset($request['address']) ? $request->input('address') : null,
            'domicile' 	    => isset($request['domicile']) ? $request->input('domicile') : null,
        ]);
        
    }

    public function updatePasswordDonatur(Request $request, $id)
    {
        $data = $this->show($id);
        if(isset($request['passwordBaru'])){
			if(strlen($request['passwordBaru']) > 20){
				$password = $request['passwordBaru'];
			}else{
				$password = Hash::make($request['passwordBaru']);
			}
		}else {
			$password = null;
		}

        $data->update([
            'password' => $password,
        ]);

        return $data;
        
    }

    public function getCityByProvince($id){
        return $this->city
                ->where('province_id', '=', $id)
                ->orderBy('name','ASC')
                ->get();
    }

    public function getDistrictByCity($id){
        return $this->district
                ->where('city_id', '=', $id)
                ->orderBy('name','ASC')
                ->get();
    }

    public function getAreaByDistrict($id){
        return $this->area
                ->where('district_id', '=', $id)
                ->orderBy('name','ASC')
                ->get();
    }

    public function getApiToken($api){
        return $this->model
                    ->where('api_token', $api)
                    ->first();
    }

    public function getCountry(){
        return $this->country
                ->get();
    }

    public function getProvince(){
        return $this->province
                ->get();
    }

    public function getCity(){
        return $this->city
                ->get();
    }

    public function getDistrict(){
        return $this->district
                ->get();
    }

    public function getArea(){
        return $this->area
                ->get();
    }

    public function getCategory(){
        return $this->category
                ->where('enabled', 1)
                ->get();
    }

    public function updateTokenDonatur()
    {
        $data = $this->model->where('id', Auth::user()->id);

        $data->update([
            'slug_token' => Str::random(5),
        ]);
    }

    public function updateAktifasiDonatur($email)
    {
        $data = $this->model->where('email', $email);

        $data->update([
            'email_verified' => 1,
            'activated' => 1,
            'otp'   => NULL,
        ]);
    }

    public function getByPhone($phone)
    {
        return $this->model->where('phone_number', $phone)->first();
    }

    public function getBankAccount()
    {
        return $this->bankAccount->where('enabled', 1)->get();
    }

    public function getCorporate($id)
    {
        return $this->corporate->where('id', $id)->first();
    }

    public function getTipeCorporate()
    {
        return $this->typeCorporate->where('enabled', 1)->get();
    }

    public function getByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function paginateCampaigner(Request $request)
    {
        $data = $this->model
                    ->when(request()->name, function($query) {
                        $query->where('name', 'like', '%'.request()->name.'%');
                    })
                    ->when(request()->is_campaigner, function($query) {
                        $query->where('is_campaigner', 'like', '%'.request()->is_campaigner.'%');
                    })
                    ->when(request()->type_campaigner, function($query) {
                        $query->where('type_campaigner', 'like', '%'.request()->type_campaigner.'%');
                    })
                    ->when(request()->type_campaigner, function($query) {
                        $query->where('type_campaigner', 'like', '%'.request()->type_campaigner.'%');
                    })
                    ->when(request()->created_at, function($query) {
                        $query->where('created_at', 'like', '%'.request()->created_at.'%');
                    })
                    ->when(request()->start_date && request()->end_date, function($query) {
                        $query->whereBetween('created_at', [request()->start_date, request()->end_date]);
                    })
                    ->whereNotNull('is_campaigner')
                    ->orderBy('created_at','DESC')
                    ->paginate($request->input('limit', 15))
                    ->appends(request()->query());
         
        return $data;
    }

    public function approvalCampaigner($id, $data){
        $approve = NULL;
        DB::beginTransaction();
        try {
            if ($data == 'VERIFIED') {
                $approve =  $this->model
                            ->where('id', $id)
                            ->update([ 
                                'is_campaigner' => $data,
                            ]);
            }else{
                $approve =  $this->model
                            ->where('id', $id)
                            ->first();
                
                if($approve->hasCorporate != NULL) {
                    $approve->update([ 
                            'is_campaigner' => NULL,
                            'type_campaigner' => NULL,
                        ]);
                    
                    $approve->hasCorporate->delete();
                } else {
                    $approve->update([ 
                        'is_campaigner' => NULL,
                        'type_campaigner' => NULL,
                    ]);
                }
                          
            }

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $approve = $th;
        }
        return $approve;
    }

    public function getDonationByAuth()
    {
        return $this->transaction->where('donatur_id', Auth::guard('member')->user()->id)
                                 ->get();
    }

    public function getFundraiserByAuth()
    {
        return $this->transaction->where('fundraiser_id', Auth::guard('member')->user()->id)
                                 ->where('transaction_status_id', 'VERIFIED')
                                 ->groupBy('campaign_id')
                                 ->get();
    }

    public function getTransactionByNumber()
    {
        return $this->transaction->where('donatur_id', Auth::guard('member')->user()->id)
                                 ->where('payment_method', 'BANKTRANSFER')
                                 ->where('transaction_status_id', 'UNVERIFIED')
                                 ->where('is_delete', 0)
                                 ->get();
    }

    public function firstTransactionByNumber($id)
    {
        return $this->transaction->where('donatur_id', Auth::guard('member')->user()->id)
                                 ->where('payment_method', 'BANKTRANSFER')
                                 ->where('transaction_status_id', 'UNVERIFIED')
                                 ->where('is_delete', 0)
                                 ->where('transaction_number', $id)
                                 ->first();
    }

    public function getFundraiser($id)
    {
        return $this->transaction
                    ->join('dns_campaigns', 'dns_campaigns.id', '=', 'dns_transactions.campaign_id')
                    ->select(
                        DB::raw('count(dns_transactions.id) as jumlahTransaksi'),
                        DB::raw('sum(dns_transactions.amount) as nominalTransaksi'),
                        DB::raw('sum(dns_transactions.unique_code) as uniqueCode'),
                        DB::raw('dns_transactions.fundraiser_id as fundraiser_id'),
                        DB::raw('dns_transactions.campaign_id as campaign_id'),
                    )
                    ->where('dns_campaigns.id', $id)
                    ->whereNotNull('dns_transactions.fundraiser_id')
                    ->where('dns_transactions.transaction_status_id', 'VERIFIED')
                    ->where('dns_transactions.is_delete', 0)
                    ->groupBy('dns_transactions.fundraiser_id')
                    ->first();
    }

    public function detailDonation($id)
    {
        return $this->transaction->where('donatur_id', Auth::guard('member')->user()->id)
                                 ->where('id', $id)
                                 ->first();
    }

    public function getCampaign($id)
    {
        return CampaignList::where('id', $id)->first();
    }

    public function getKontakWhatsapp()
    {
        $data = $this->profileRepository->findOrFail('2020151001001');
        $staticPage = json_decode($data->phone_number);
        return $staticPage = [
            'phone' => $staticPage->phone_1
        ];
    }
}
