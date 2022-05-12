<?php

namespace App\Http\Controllers\Backoffice\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DigiBase\Controller\BaseController;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use App\Repositories\TransactionRepository;
use App\Models\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MultipleSheet;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportTransactionController extends BaseController
{
    protected $repository;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(TransactionRepository $repository)
	{
		$permission = Permission::where('name', 'LIKE', 'laporan-transaksi-%')->get();
		//dd($permission);
		for($i = 0; $i < count($permission); $i++){
			if(strstr($permission[$i]['name'], 'list')){
				$this->middleware('permission:'.$permission[$i]['name'], ['only' => ['index','show']]);
			}elseif(strstr($permission[$i]['name'], 'create')){
				$this->middleware('permission:'.$permission[$i]['name'], ['only' => ['create','store']]);
			}elseif(strstr($permission[$i]['name'], 'edit')){
				$this->middleware('permission:'.$permission[$i]['name'], ['only' => ['edit','update']]);
			}elseif(strstr($permission[$i]['name'], 'delete')){
				$this->middleware('permission:'.$permission[$i]['name'], ['only' => ['destroy']]);
			}
		}

        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
			$hasPermissions = Permission::where('name', 'LIKE', 'laporan-transaksi-%')->get();

            $summary['sum-verified-transaction'] = $this->repository->getTransactionByStatus('VERIFIED', 'sum');
            $summary['sum-unverified-transaction'] = $this->repository->getTransactionByStatus('UNVERIFIED', 'sum');

            $summaryToday['sum-verified-transaction'] = $this->repository->getTransactionTodayByStatus('VERIFIED', 'sum');
            $summaryToday['sum-unverified-transaction'] = $this->repository->getTransactionTodayByStatus('UNVERIFIED', 'sum');

            $data = $this->repository->paginate($request);
            
			return $this->makeView('backoffice.report.transaction.index', compact('data', 'summary', 'summaryToday', 'hasPermissions'));
		} catch (\Exception $exc) {
			return $this->goTo500Page($exc);
        }
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $id = $this->decodeHash($id);
            $data = $this->repository->show($id);

            $dataDonatur = $this->repository->getDonatur($data->campaign_id);
            $dataTransaction = $this->repository->getTransactionByCampaign($data->campaign_id);

            $chartVerifiedWeekly = json_encode($this->repository->summaryTransactionTypeIdWeekly($data->campaign_id, "VERIFIED", "DONASI"));
            $chartUnverifiedWeekly = json_encode($this->repository->summaryTransactionTypeIdWeekly($data->campaign_id, "UNVERIFIED", "DONASI"));

            $chartVerified = json_encode($this->repository->summaryTransactionTypeIdYearly($data->campaign_id, "VERIFIED", "DONASI"));
            $chartUnverified = json_encode($this->repository->summaryTransactionTypeIdYearly($data->campaign_id, "UNVERIFIED", "DONASI"));

            $dataTransactionYearly = $this->repository->getDataTransactionTypeIdYearly($data->campaign_id, "DONASI");
            $dataTransactionWeekly = $this->repository->getDataTransactionTypeIdWeekly($data->campaign_id, "DONASI");
            $dataTransactionDaily = $this->repository->getDataTransactionTypeIdToday($data->campaign_id, "DONASI");
            
            $dataTransactionDailyPaginate = $this->paginate($dataTransactionDaily);
            $dataTransactionDailyPaginate->withPath('');

            return $this->makeView('backoffice.report.transaction.show', compact('data', 'dataDonatur', 'chartVerified', 'chartUnverified', 'chartVerifiedWeekly', 'chartUnverifiedWeekly', 'dataTransaction', 'dataTransactionYearly', 'dataTransactionWeekly','dataTransactionDailyPaginate'));
		} catch (\Exception $exc) {
			return $this->goTo500Page($exc);
        }
    }

    public function exportExcel($id)
    {
        try {
			$id = $this->decodeHash($id);
            return Excel::download(new MultipleSheet($id), 'Laporan-Donasi.xlsx');
        } catch (\Exception $exc) {
            return $this->goTo500Page($exc);
        }
    }

    private function paginate($items, $perPage = 7, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage ;
        $itemstoshow = array_slice($items , $offset , $perPage);
        return new LengthAwarePaginator($itemstoshow ,$total   ,$perPage);
    }
}