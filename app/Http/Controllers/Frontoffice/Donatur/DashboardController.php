<?php

namespace App\Http\Controllers\Frontoffice\Donatur;

use App\Http\Controllers\Controller;
use App\DigiBase\Controller\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Repositories\DonaturRepository;
use App\Repositories\ConfirmationManualRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth, PDF;

class DashboardController extends BaseController
{
    protected $repository, $confirmationRepository;

    /**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(DonaturRepository $repository, ConfirmationManualRepository $confirmationRepository)
	{
        $this->repository = $repository;
        $this->confirmationRepository = $confirmationRepository;
	}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $title = "Akun Saya";
            $activeMenu = "overview";
            $data = $this->repository->getDonationByAuth();
            $dataFundraiser = $this->repository->getFundraiserByAuth();

            return $this->makeView('frontoffice.donatur.dashboard', compact('activeMenu', 'title', 'data', 'dataFundraiser'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
       
    }

    public function historyTransaction()
    {
        //    
    }

    public function kwitansi($id)
    {
        //
    }

    public function confirmationManual()
    {
        try {
            $data = $this->repository->getTransactionByNumber();
            $bank = $this->repository->getBankAccount();
            $title = "Konfirmasi Pembayaran";

            return $this->makeView('frontoffice.donatur.confirmationManual', compact('title', 'data', 'bank'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
		}
    }

    public function confirmationByTransaction($transaction)
    {
        try {
            $title = "Konfirmasi Pembayaran";

            return $this->makeView('frontoffice.donatur.confirmationManual', compact('title'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }   
    }

    public function confirmationManualProcess(Request $request)
    {
        $validator = $this->validator($request);

        if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

        $request['id'] = $this->GenerateAutoNumber('dns_manual_confirmations');
        $request['confirmation_date'] = Carbon::createFromFormat('d/m/Y', $request->confirmation_date)->format('Y-m-d H:i:s'); 
        
        if (!empty($request->file('image'))) {
            if (\File::exists(public_path('/assets/images/manualConfirmation' . $request->image))) {
                \File::delete(public_path('/assets/images/manualConfirmation' . $request->image));
            }
            $image = time() . '.' .$request->file('image')->getClientOriginalExtension();
            $destinationPath = public_path('/assets/images/manualConfirmation');
            $request->file('image')->move($destinationPath, $image);

        }
        $data = $this->confirmationRepository->store($request);

         if ($data->errorInfo != null) {
             return redirect()->route('dashboard-confirmation_manual')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
         }
        if (Auth::user()) {
            return redirect()->route('dashboard-confirmation_manual')->with('success', 'Konfirmasi Berhasil ditambahkan');
        } else {
            return redirect()->route('dashboard-users')->with('success', 'Konfirmasi berhasil ditambahkan');
        }
    }

   

    public function fundraiser()
    {
        try {
            $title = "Fundraising Saya";
            $data = $this->repository->getFundraiserByAuth();
            $category = $this->repository->getCategory();

            return $this->makeView('frontoffice.donatur.fundraiser', compact('title', 'data', 'category'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }  
    }

    public function fundraiserDetail($id)
    {
        try {
            $id = $this->decodeHash($id);
            $data = $this->repository->getFundraiser($id);
            $campaign = $this->repository->getCampaign($id);
            $countVisitor = views($campaign)->count();
            $title = $data->hasCampaign->title;

            return $this->makeView('frontoffice.donatur.fundraiser-detail', compact('title', 'data', 'countVisitor'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }  
    }

    public function getDataTransaction($id)
    {
        try {
            $data = $this->repository->firstTransactionByNumber($id);
            $image = $data->hasCampaign->image;
            return response()->json([$data, $image]);
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        } 
    }

    public function getMyDonation()
    {
        try {
            $title = 'Riwayat Donasi';
			$data = $this->repository->getDonationByAuth();

            if (!$data) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return $this->makeView('frontoffice.donatur.donation.index', compact('data', 'title'));
        } catch (\Exception $exc) {
             return $this->goTo500Page($exc);
        }
    }

    public function detailMyDonation($id)
    {
        try {
            $id = $this->decodeHash($id);
            $data = $this->repository->detailDonation($id);
            $title = $data->hasCampaign->title;
            $noHp = $this->repository->getKontakWhatsapp();
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

            if (!$data) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return $this->makeView('frontoffice.donatur.donation.detail', compact('data', 'kontak', 'title'));
        } catch (\Exception $exc) {
             return $this->goTo500Page($exc);
        }
    }

    public function cancelMyDonation($id)
    {
        try {
            $id = $this->decodeHash($id);
            $data = $this->repository->detailDonation($id);
            $data->update([
                'transaction_status_id' => 'CANCEL',
            ]);

            if (!$data) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return redirect()->back()->with('success', 'Donasi telah dibatalkan');
        } catch (\Exception $exc) {
             return $this->goTo500Page($exc);
        }
    }

    private function validator(Request $request)
	{
		return Validator::make($request->all(), [
                'transaction_number' => 'required',
                'confirmation_date' => 'required',
                'bank_account_id' => 'required',
                'amount'    => 'required',
                'image'        => 'image|mimes:jpg,png,jpeg,gif,svg|max:1000|unique:dns_banks,image,'.$request->id,
            ],[
				'transaction_number.required' => ':attribute Wajib Diisi',
                'confirmation_date.required' => ':attribute Wajib Diisi',
                'amount.required' => ':attribute Wajib Diisi',
                'bank_account_id.required' => ':attribute Wajib Diisi',
                'image.required' => ':attribute Wajib Diisi',
                'image.mimes'	 => 'Format :attribute Harus jpg,jpeg,png,bmp,tiff',
			    'image.max'	     => ':attribute Maksimal :max Kb',
			],[
				'transaction_number' => 'Transaksi',
                'confirmation_date' => 'Tanggal Transfer',
                'bank_account_id' => 'Bank',
                'amount' => 'Nominal',
                'image' => 'Gambar',
			]);
	}
}
