<?php

namespace App\Http\Controllers\Frontoffice\Donatur;

use App\Http\Controllers\Controller;
use App\DigiBase\Controller\BaseController;
use App\Jobs\UpdateCampaign;
use Illuminate\Support\Facades\Validator;
use App\Repositories\CampaignRepository;
use App\Repositories\DonaturRepository;
use App\Repositories\CampaignUpdateRepository;
use App\Repositories\WidhdrawalRepository;
use App\Repositories\LandingPageRepository;
use App\Mail\Widhdrawal;
use Illuminate\Support\Facades\Mail;
use App\Mail\UpdateCampaignMail;
use Illuminate\Http\Request;
use App\Exports\ListDonaturExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Auth, PDF, Hash;

class CampaignController extends BaseController
{
    protected $repository, $repoDonatur, $campaignUpdateRepo, $widhdrawalRepo, $landingRepo;

    /**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(CampaignRepository $repository, DonaturRepository $repoDonatur, CampaignUpdateRepository $campaignUpdateRepo, widhdrawalRepository $widhdrawalRepo, LandingPageRepository $landingRepo)
	{
        $this->repository = $repository;
        $this->repoDonatur = $repoDonatur;
        $this->campaignUpdateRepo = $campaignUpdateRepo;
        $this->widhdrawalRepo = $widhdrawalRepo;
        $this->landingRepo = $landingRepo;
	}
    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexCorporate()
    {
        try {
            $data = $this->repository->getCorporate();
            $title = $data->corporate_name;
            $campaign = $this->repository->getCampaignByUser();

            return $this->makeView('frontoffice.corporate.index', compact('title', 'data', 'campaign'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    public function editCorporate($id)
    {
        $id = $this->decodeHash($id);
        $data = $this->repository->showCorporate($id);
        $country = $this->repoDonatur->getCountry();
        $province = $this->repoDonatur->getProvince();
        $city = $this->repoDonatur->getCity();
        $district = $this->repoDonatur->getDistrict();
        $title = 'Pengaturan';

        return $this->makeView('frontoffice.corporate.edit', compact('title', 'data', 'country', 'province', 'city', 'district'));
    }

    public function updateCorporate(Request $request, $id)
    {
        try {
            $request['id'] = $id;
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

			if(empty($request->file('image'))) {
                $data = $this->repoDonatur->showCorporate($id);
				$request['image'] = $data->image;
			}

            if (!empty($request->file('file_akta'))) {
				if (\File::exists(public_path('/assets/file_akta/corporate' . $request->file_akta))) {
                    \File::delete(public_path('/assets/file_akta/corporate' . $request->file_akta));
				}
				$file_akta = time() . '.' .$request->file('file_akta')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/file_akta/corporate');
				$request->file('file_akta')->move($destinationPath, $file_akta);
			}

			if(empty($request->file('file_akta'))) {
                $data = $this->repoDonatur->showCorporate($id);
				$request['file_akta'] = $data->file_akta;
			}

            if (!empty($request->file('ktp_pic'))) {
				if (\File::exists(public_path('/assets/pic/ktp' . $request->ktp_pic))) {
                    \File::delete(public_path('/assets/pic/ktp' . $request->ktp_pic));
				}
				$ktp_pic = time() . '.' .$request->file('ktp_pic')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/pic/ktp');
				$request->file('ktp_pic')->move($destinationPath, $ktp_pic);
			}

            if(empty($request->file('ktp_pic'))) {
                $data = $this->repoDonatur->showCorporate($id);
				$request['ktp_pic'] = $data->ktp_pic;
			}

            if (!empty($request->file('image_selfie_pic'))) {
				if (\File::exists(public_path('/assets/pic/images' . $request->image_selfie_pic))) {
                    \File::delete(public_path('/assets/pic/images' . $request->image_selfie_pic));
				}
				$image_selfie_pic = time() . '.' .$request->file('image_selfie_pic')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/pic/images');
				$request->file('image_selfie_pic')->move($destinationPath, $image_selfie_pic);
			}

            if(empty($request->file('image_selfie_pic'))) {
                $data = $this->repoDonatur->showCorporate($id);
				$request['image_selfie_pic'] = $data->image_selfie_pic;
			}

            if($request->snk == 1) {
                $data = $this->repoDonatur->updateCampaignerCorporate($request, $id);
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
    public function indexPersonal()
    {
        try {
            $title = 'Personal';
            $campaign = $this->repository->getCampaignByUser();

            return $this->makeView('frontoffice.campaigner.detail', compact('title', 'campaign'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    
    public function editPersonal($id)
    {
        $id = $this->decodeHash($id);
        $country = $this->repoDonatur->getCountry();
        $province = $this->repoDonatur->getProvince();
        $city = $this->repoDonatur->getCity();
        $district = $this->repoDonatur->getDistrict();
        $title = 'Pengaturan Perorangan';

        return $this->makeView('frontoffice.campaigner.edit', compact('title', 'country', 'province', 'city', 'district'));
    }

    public function updatePersonal(Request $request, $id)
    {
        try {
            $validator = $this->validator($request);

			if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

            if (!empty($request->file('image_ktp'))) {
                $data = $this->repoDonatur->show(Auth::guard('member')->user()->id);
                if (\File::exists(public_path('/assets/images/donatur/ktp' . $data->image_ktp))) {
                    \File::delete(public_path('/assets/images/donatur/ktp' . $data->image_ktp));
                }
                $image_ktp = time() . '.' .$request->file('image_ktp')->getClientOriginalExtension();
                $destinationPath = public_path('/assets/image_ktp/donatur/ktp');
                $request->file('image_ktp')->move($destinationPath, $image_ktp);
            }

            if(empty($request->file('image_ktp'))) {
                $data = $this->repoDonatur->show(Auth::guard('member')->user()->id);
                $request['image_ktp'] = $data->image_ktp;
            }

            if (!empty($request->file('image_selfie'))) {
                $data = $this->repoDonatur->show(Auth::guard('member')->user()->id);
                if (\File::exists(public_path('/assets/images/donatur/ktp' . $data->image_selfie))) {
                    \File::delete(public_path('/assets/images/donatur/ktp' . $data->image_selfie));
                }
                $image_selfie = time() . '.' .$request->file('image_selfie')->getClientOriginalExtension();
                $destinationPath = public_path('/assets/image_selfie/donatur/ktp');
                $request->file('image_selfie')->move($destinationPath, $image_selfie);
            }

            if(empty($request->file('image_selfie'))) {
                $data = $this->repoDonatur->show(Auth::guard('member')->user()->id);
                $request['image_selfie'] = $data->image_selfie;
            }  

            // if($request->snk == 1) {
            $data = $this->repoDonatur->updateCampaignerPersonal($request, Auth::guard('member')->user()->id);

            if ($data != true) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

                return redirect()->route('success-pageCampaigner');
            // } else {
            //     return redirect()->back()->with('error', 'Harap setujui ketentuan yang sudah tertera!') ;
            // }
            
        } catch(\Exception $exc){
            return $this->goTo500Page($exc);
        }
    }


    public function onBoardCampaign()
    {
        try {
            if(Auth::guard('member')->user()->is_campaigner == 'VERIFIED') {
                $title = 'Galang Dana';
                $noHp = $this->landingRepo->getKontakWhatsapp();
                $phone = str_replace(" ","",$noHp);
                // kadang ada penulisan no hp (0274) 778787
                $phone = str_replace("(","",$noHp);
                // kadang ada penulisan no hp (0274) 778787
                $phone = str_replace(")","",$noHp);
                // kadang ada penulisan no hp 0811.239.345
                $phone = str_replace(".","",$noHp);
                if(!preg_match('/[^+0-9]/',trim($phone['phone']))){
                    // cek apakah no hp karakter 1-3 adalah +62
                    if(substr(trim($phone['phone']), 0, 1)=='0'){
                        $kontak = '62'.substr(trim($phone['phone']), 1);
                    }
                }
                $faq = $this->repository->getFaq();

                return $this->makeView('frontoffice.campaign.index', compact('title', 'faq', 'kontak'));
            } else { 
                return redirect()->route('dashboard-users');
            }
          
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    public function indexCreateCampaign()
    {
        try {
            $title = 'Buat Campaign';
            $category = $this->repository->getCategory();
            @$term = $this->repository->getTerm();

            return $this->makeView('frontoffice.campaign.create-form', compact('title', 'term', 'category'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    public function formCampaign(Request $request)
    {
        try {
            $request['id'] = $this->GenerateAutoNumber('dns_campaigns');
            $request['user_id'] = Auth::guard('member')->user()->id;
            $request['enabled'] = 1;
            $customAmount = json_encode(str_replace(".", "",$request->custom_amount));
            if($request->open_goal == 0) {
                $request['valid_date'] = isset($request['valid_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->input('valid_date'))->format('Y-m-d') : null;
            }
            $request['custom_amount'] = json_decode($customAmount);
            
            $validator = $this->validatorCampaign($request);

			if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

            if (!empty($request->file('image'))) {
				if (\File::exists(public_path('/assets/images/campaign' . $request->image))) {
                    \File::delete(public_path('/assets/images/campaign' . $request->image));
				}
				$image = time() . '.' .$request->file('image')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/images/campaign');
				$request->file('image')->move($destinationPath, $image);
			}

            if (!empty($request->file('background'))) {
				if (\File::exists(public_path('/assets/images/campaign' . $request->background))) {
                    \File::delete(public_path('/assets/images/campaign' . $request->background));
				}
				$background = time() . '.' .$request->file('background')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/images/campaign');
				$request->file('background')->move($destinationPath, $background);
			}

			$data = $this->repository->store($request);
            
            return redirect()->route('success-campaign');
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    public function indexEditCampaign($id)
    {
        try {
            $title = 'Ubah Campaign';

            $id = $this->decodeHash($id);
            $data = $this->repository->show($id);
            $category = $this->repository->getCategory();
            $custom_amount = json_decode($data->custom_amount);
            @$term = $this->repository->getTerm();

            return $this->makeView('frontoffice.campaign.edit-form', compact('title', 'term', 'category', 'data', 'custom_amount'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    public function formCampaignUpdate(Request $request, $id)
    {
        try {
            $request['id'] = $id;
            $request['user_id'] = Auth::guard('member')->user()->id;
            $request['enabled'] = 1;

            if (!empty($request->file('image'))) {
                $data = $this->repository->show($id);
				if (\File::exists(public_path('/assets/images/campaign/' . $data->image))) {
                    \File::delete(public_path('/assets/images/campaign/' . $data->image));
				}
				$image = time() . '.' .$request->file('image')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/images/campaign/');
				$request->file('image')->move($destinationPath, $image);
			}

			if(empty($request->file('image'))) {
				$data = $this->repository->show($id);
				$request['image'] = $data->image;
			}

            if (!empty($request->file('background'))) {
                $data = $this->repository->show($id);
				if (\File::exists(public_path('/assets/background/campaign/' . $data->background))) {
                    \File::delete(public_path('/assets/background/campaign/' . $data->background));
				}
				$background = time() . '.' .$request->file('background')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/background/campaign/');
				$request->file('background')->move($destinationPath, $background);
			}

			if(empty($request->file('background'))) {
				$data = $this->repository->show($id);
				$request['background'] = $data->background;
			}

			$data = $this->repository->update($id, $request);
            
            return redirect()->route('success-edit-campaign');
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    public function pageUpdateNew($id)
    {
        try {
            $id = $this->decodeHash($id);
            $campaign = $this->repository->show($id);
            $title = $campaign->title;
            $data = $this->campaignUpdateRepo->getDataByCampaign($id);

            return $this->makeView('frontoffice.campaign.update.index', compact('title', 'data', 'campaign'));

        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    public function createUpdateNew($id)
    {
        try {
            $title = 'Tambah Kabar Terbaru';
            $id = $this->decodeHash($id);
            $data = $this->repository->show($id);

            return $this->makeView('frontoffice.campaign.update.form', compact('title', 'data'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    public function storeUpdate(Request $request)
    {
        try {
            $request['id'] = $this->GenerateAutoNumber('dns_campaign_updates');
            $request['created_by'] = Auth::guard('member')->user()->name;
            $request['enabled'] = 1;
            $validator = $this->validatorCampaignUpdate($request);

			if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

			$data = $this->campaignUpdateRepo->store($request);
            $donatur = $this->campaignUpdateRepo->getTransactionByCampaign($data->campaign_id);
            
            if($data != NULL && $donatur != NULL){
                $this->sendMailUpdateNew($data, $donatur);
            }
            
            
            $title = "Tambah Kabar Terbaru Berhasil";
            return $this->makeView('frontoffice.campaign.update.success-form', compact('data', 'title'));

        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    public function editUpdateNew($id)
    {
        try {
            $title = 'Edit Kabar Terbaru';
            $id = $this->decodeHash($id);
            $data = $this->campaignUpdateRepo->show($id);

            return $this->makeView('frontoffice.campaign.update.edit', compact('title', 'data'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    public function updateUpdateNew(Request $request, $id)
    {
        try {
            $request['id'] = $id;
            $request['user_id'] = Auth::guard('member')->user()->id;
            $request['enabled'] = 1;

			$data = $this->campaignUpdateRepo->update($id, $request);
            
            $title = "Ubah Kabar Terbaru Berhasil";
            return $this->makeView('frontoffice.campaign.update.success-form', compact('data', 'title'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    public function deleteUpdateNew($id)
    {
        try {
            $id = $this->decodeHash($id);
            $data = $this->campaignUpdateRepo->delete($id);

            if (!$data) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return redirect()->back();

        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    } 

    public function successCreateForm()
    {
        try {
            $title = 'Telah berhasil ditambahkan';

            return $this->makeView('frontoffice.campaign.success-form', compact('title'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    public function successEditForm()
    {
        try {
            $title = 'Telah berhasil diubah';

            return $this->makeView('frontoffice.campaign.success-edit-form', compact('title'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    public function widhdrawal($id)
    {
        try {
            $data = $this->repository->campaignDetail($id);
            $historyWidhdrawal = $this->widhdrawalRepo->getDataByCampaign($data->id);
            $title = $data->title;

            return $this->makeView('frontoffice.campaign.widhdrawal.index', compact('title', 'data', 'historyWidhdrawal'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    public function exportDonatur($id)
    {
        try {
            return Excel::download(new ListDonaturExport($id), 'Laporan-Donatur.xlsx');
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    public function confirmationPassword(Request $request, $slug)
    {
        try {
            if(Hash::check($request->password, Auth::guard('member')->user()->password)) {
                return redirect()->route('dashboard-widhdrawa.create', $slug);
            } else {
                return redirect()->back()->with('error', 'Password yang kamu masukan tidak sesuai');
            }
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    public function widhdrawalCreate($id)
    {
        try {
            $data = $this->repository->campaignDetail($id);
            $bank = $this->widhdrawalRepo->getBankCampaigner();
            $title = 'Cairkan Dana';

            return $this->makeView('frontoffice.campaign.widhdrawal.create', compact('title', 'data', 'bank'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    public function widhdrawalStore(Request $request)
    {
        try {
            $request['id'] = $this->GenerateAutoNumber('dns_widhdrawals');
            $request['user_id'] = Auth::guard('member')->user()->id;
            $request['request_date'] = Carbon::now();
            $request['status'] = 'UNVERIFIED';

            if (str_replace('.', '', str_replace('Rp ', '', $request->input('amount'))) <= str_replace('.', '', str_replace('Rp ', '', $request->input('collected')))) {
                $campaign = $this->repository->showCampaign($request->campaign_id);

                $validator = $this->validatorWidhdrawal($request);
    
                if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
    
                $data = $this->widhdrawalRepo->store($request);
                // Send Mail
                $this->sendMail($data);
                
    
                return redirect()->route('dashboard-widhdrawal', $campaign->slug);
            } else {
                return redirect()->back()->with('error', 'Saldo yang kamu inputkan terlalu besar');
            }

        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myCampaign()
    {
        try {
            $title = 'Campaign Saya';
            $data = $this->repository->getCampaignByUser();
            $category = $this->repository->getCategory();

            return $this->makeView('frontoffice.campaign.list-campaign', compact('title', 'data', 'category'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    protected function sendMail($data)
    {
        try {
            $email = new \App\Mail\Widhdrawal($data);
            Mail::to(Auth::guard('member')->user()->email)->send($email);
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    protected function sendMailUpdateNew($data, $donatur)
    {
        try {
            $donatur = json_decode($donatur);
            UpdateCampaign::dispatch($data, $donatur)
                        ->delay(now()->addSeconds(5));

        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    

    private function validatorCorporate(Request $request)
	{
		return Validator::make($request->all(), [
                // Corporate
                'nib'           => 'required|max:20|unique:dns_corporate_details,nib,'.$request->id,
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
            ],[
                // Corporate
                'nib.required' => ':attribute Wajib Diisi',
                'nib.unique'		=> ':attribute Sudah Terdaftar',
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
                
			],[
                'nib' => 'NIB',
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
                'image_ktp'     => 'image|mimes:jpg,png|max:1000'.$request->id,
                'image_selfie'  => 'image|mimes:jpg,png|max:1000'.$request->id,
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
                // 'codepos.required' => ':attribute Wajib Diisi',
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
                // 'codepos'   => 'Kode POS',
                'image_ktp' => 'Foto KTP',
                'image_selfie' => 'Foto Selfie KTP',
			]);
	}

    private function validatorCampaign(Request $request)
	{
		return Validator::make($request->all(), [
                'title' 			=> 'required',
                'slug' => 'required|unique:dns_campaigns,slug,'.$request->id,
                'categories_id' => 'required',
                'image'        => 'image|mimes:jpg,png,jpeg,gif,svg|max:6000|unique:dns_campaigns,image,'.$request->id,
                'description' 		=> 'required',
            ],[
				'title.required' => ':attribute Wajib Diisi',
                'slug.required' => ':attribute Wajib Diisi',
                'categories_id.required' => ':attribute Wajib Diisi',
                'image.required' => ':attribute Wajib Diisi',
                'image.mimes'	 => 'Format :attribute Harus jpg,jpeg,png,bmp,tiff',
			    'image.max'	     => ':attribute Maksimal :max Kb',
                'description.required' => ':attribute Wajib Diisi',
                'slug.unique'		=> ':attribute Sudah Terdaftar',
			],[
				'title' => 'Judul',
                'slug'  => 'Slug',
                'categories_id' => 'Kategori',
                'image' => 'Gambar',
                'description' => 'Konten',
			]);
	}

    private function validatorCampaignUpdate(Request $request)
	{
		return Validator::make($request->all(), [
                'title' 			=> 'required',
                'content' 		=> 'required',
            ],[
				'title.required' => ':attribute Wajib Diisi',
                'content.required' => ':attribute Wajib Diisi',
			],[
				'title' => 'Judul',
                'content' => 'Konten',
			]);
	}

    private function validatorWidhdrawal(Request $request)
	{
		return Validator::make($request->all(), [
                'bank_account_id' => 'required',
                'amount' => 'required|regex:([0-9])',
                'description' => 'required',
            ],[
				'bank_account_id.required' => ':attribute Wajib Diisi',
                'amount.required' => ':attribute Wajib Diisi',
                'amount.regex'	 	=> 'Format Penulisan :attribute Salah, [0-9]',
                'description' => ':attribute Wajib Diisi',
			],[
				'bank_account_id' => 'Bank',
                'amount' => 'Nominal',
                'description' => 'Keterangan',
                
			]);
	}
}
