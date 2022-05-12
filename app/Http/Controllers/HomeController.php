<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DigiBase\Controller\BaseController;
use App\Repositories\TransactionRepository;

class HomeController extends BaseController
{
    protected $transactionRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->middleware('auth');
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $summary['all-count-transaction'] = $this->transactionRepository->getTransactionByStatus('ALL', 'count');
        $summary['all-sum-transaction'] = $this->transactionRepository->getTransactionByStatus('ALL', 'sum');

        $verifiedTransaction = json_encode($this->transactionRepository->summaryTransactionYearly('VERIFIED'));
        $cancelTransaction = json_encode($this->transactionRepository->summaryTransactionYearly('CANCEL'));
        
        $summary['count-verified-transaction'] = $this->transactionRepository->getTransactionByStatus('VERIFIED', 'count');
        $summary['sum-verified-transaction'] = $this->transactionRepository->getTransactionByStatus('VERIFIED', 'sum');

        $summary['count-cancel-transaction'] = $this->transactionRepository->getTransactionByStatus('CANCEL', 'count');
        $summary['sum-cancel-transaction'] = $this->transactionRepository->getTransactionByStatus('CANCEL', 'sum');

        $summary['count-unverified-transaction'] = $this->transactionRepository->getTransactionByStatus('UNVERIFIED', 'count');
        $summary['sum-unverified-transaction'] = $this->transactionRepository->getTransactionByStatus('UNVERIFIED', 'sum');

        return $this->makeView('home', compact('verifiedTransaction', 'cancelTransaction', 'summary'));
    }
}
