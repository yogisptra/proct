<?php

namespace App\Http\Controllers\Frontoffice;

use App\DigiBase\Controller\BaseController;
use App\Jobs\SendMailCommitmentJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB, Auth, Str;
use App\Mail\CommitmentMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Transaction;
use App\Models\BankAccount;
use App\Repositories\TransactionRepository;
use App\Repositories\LandingPageRepository;

class TransactionController extends BaseController
{
    protected $repository, $repoCampaign;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
    
	function __construct(TransactionRepository $repository, LandingPageRepository $repoCampaign)
	{
        $this->repository = $repository;
        $this->repoCampaign = $repoCampaign;
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        try {
            $title = 'Pembayaran';
            $data = $this->repoCampaign->campaignDetail($slug);
            $dataCustomMin = json_decode($data->hasCampaign->custom_amount);
            $bank = $this->repoCampaign->getBankAccount();

            return $this->makeView('frontoffice.payment.index', compact('data', 'title', 'bank', 'dataCustomMin'));
            
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        } 
    }

    public function store(Request $request)
    {
        try {
            $validator = $this->validator($request);

			if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
            // Konversi Rp ke bilangan integer
            $request['amount'] = isset($request['amount']) ? str_replace('.', '', str_replace('Rp ', '', $request->input('amount'))) : null;

            // Cek Bank Akun
            $bankAccountCheck = BankAccount::where('id', $request->bank_account_id)->first();
            $bankType = $bankAccountCheck->type;
            $bankName = $bankAccountCheck->hasbank->name;

            // Get Campaign Donasi By Slug
            $campaign = $this->repoCampaign->campaignDetail($request->slug);
            
            $request['id'] = $this->GenerateAutoNumber('dns_transactions');
            $request['transaction_number'] = 'INV-' . $this->GenerateAutoNumber('dns_transactions');
            $request['campaign_id'] = $campaign->id;
            $request['type_transaction_id'] = 'DONASI';
            $request['payment_method'] = 'BANKTRANSFER';
            $request['unique_code'] = $this->generateNumeric(3);

            // Pengecekan Apabila Bank Transfer Create Kode Unik
            if($bankType == 'TF'){
                $request['unique_code'] = $this->generateNumeric(3);
                $request['payment_method'] = 'BANKTRANSFER';
            }

            if(Auth::guard('member')->user()){
                $request['donatur_id'] = Auth::guard('member')->user()->id;
                $request['name'] = Auth::guard('member')->user()->name;
                $request['email'] = Auth::guard('member')->user()->email;
                $request['phone_number'] = Auth::guard('member')->user()->phone_number;
            }

            // store transaction
            $data = $this->repository->store($request);
            
            if ($data->errorInfo != null || !$data->exists) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            // sendMail
            if($data->email != null){
                $this->sendMail($data);
            }

            if($request['donatur_id'] != null ) {
                return redirect()->route('frontoffice.invoice', [$request['transaction_number']]);
            } else {
                return redirect()->route('frontoffice.invoice-user', [$request['transaction_number']]);
            }

        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    public function paymentFundraiser($slug, $token)
    {
        try {
            $data = $this->repoCampaign->campaignDetail($slug);
            $dataCustomMin = json_decode($data->hasCampaign->custom_amount);
            $bank = $this->repoCampaign->getBankAccount();
            $fundraiser = $this->repoCampaign->getSlugToken($token);
            $title = 'Pembayaran';

            return $this->makeView('frontoffice.payment.index', compact('data', 'dataCustomMin', 'bank', 'fundraiser', 'title'));
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    public function storeFundraiser($slug, Request $request)
    {
        try {
            $validator = $this->validator($request);

			if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
            // Konversi Rp ke bilangan integer
            $request['amount'] = isset($request['amount']) ? str_replace('.', '', str_replace('Rp ', '', $request->input('amount'))) : null;

            // Cek Bank Akun
            $bankAccountCheck = BankAccount::where('id', $request->bank_account_id)->first();
            $bankType = $bankAccountCheck->type;
            $bankName = $bankAccountCheck->hasbank->name;

            // Get Campaign Donasi By Slug
            $campaign = $this->repoCampaign->campaignDetail($request->slug);
            
            $request['id'] = $this->GenerateAutoNumber('dns_transactions');
            $request['transaction_number'] = 'INV-' . $this->GenerateAutoNumber('dns_transactions');
            $request['campaign_id'] = $campaign->id;
            $request['type_transaction_id'] = 'DONASI';
            $request['payment_method'] = 'BANKTRANSFER';
            $request['unique_code'] = $this->generateNumeric(3);

            // Pengecekan Apabila Bank Transfer Create Kode Unik
            if($bankType == 'TF'){
                $request['unique_code'] = $this->generateNumeric(3);
                $request['payment_method'] = 'BANKTRANSFER';
            }

            if(Auth::guard('member')->user()){
                $request['donatur_id'] = Auth::guard('member')->user()->id;
                $request['name'] = Auth::guard('member')->user()->name;
                $request['email'] = Auth::guard('member')->user()->email;
                $request['phone_number'] = Auth::guard('member')->user()->phone_number;
            }

            // store transaction
            $data = $this->repository->store($request);
            
            if ($data->errorInfo != null || !$data->exists) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            // sendMail
            if($data->email != null){
                $this->sendMail($data);
            }

            if($request['donatur_id'] != null ) {
                return redirect()->route('frontoffice.invoice', [$request['transaction_number']]);
            } else {
                return redirect()->route('frontoffice.invoice-user', [$request['transaction_number']]);
            }
           

        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invoice($id)
    {
        try {
            $title = 'Informasi Pembayaran';
            $data = $this->repository->getInvoice($id);
            $time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->transaction_date)->addDays(1)->timezone('Asia/Jakarta')->format('Y-m-d\TH:i:s');
            return $this->makeView('frontoffice.payment.invoice', compact('data', 'title', 'time'));
            
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function invoiceNon($id)
    {
        try {
            $title = 'Informasi Pembayaran';
            $data = $this->repository->getInvoice($id);
            $time = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->transaction_date)->addDays(1)->timezone('Asia/Jakarta')->format('Y-m-d\TH:i:s');
            return $this->makeView('frontoffice.payment.invoice-user', compact('data', 'title', 'time'));
            
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        } 
    }

    protected function sendMail($transaction)
    {
        try {
            SendMailCommitmentJob::dispatch($transaction)
                        ->delay(now()->addSeconds(5));
            
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    private function validator(Request $request)
	{
        if(Auth::guard('member')->user()) {
            return Validator::make($request->all(), [
                'amount'    => 'required',
                'bank_account_id'    => 'required',
            ],[
                'bank_account_id.required' => ':attribute Wajib Diisi',
                'amount.required'   => ':attribute Wajib Diisi',
			],[
                'bank_account_id' => 'Metode Pembayaran',
                'amount' => 'Nominal'
			]);
        } else {
            return Validator::make($request->all(), [
                'name' => 'required',
                'email' 			=> 'required',
                'phone_number'  => 'required|regex:([0-9])|max:14',
                'bank_account_id' => 'required',
                'amount'    => 'required',
            ],[
				'name.required' => ':attribute Wajib Diisi',
                'email.required' => ':attribute Wajib Diisi',
			    'phone_number.max'	     => ':attribute Maksimal :max Kb',
                'phone_number.required' => ':attribute Wajib Diisi',
                'phone_number.regex'	 	=> 'Format Penulisan :attribute Salah, [0-9]',
                'bank_account_id.required' => ':attribute Wajib Diisi',
                'amount.required'   => ':attribute Wajib Diisi',
			],[
				'name' => 'Nama',
                'email' => 'Email',
                'phone_number' => 'Nomor Telepon',
                'bank_account_id' => 'Metode Pembayaran',
                'amount' => 'Nominal'
			]);
        }
		
	}
}
