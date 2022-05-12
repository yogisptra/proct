<?php

namespace App\Http\Controllers\Frontoffice\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\DigiBase\Controller\BaseController;
use Spatie\Permission\Models\Permission;
use App\Repositories\CampaignRepository;
use DB, File, Auth;

class CampaignController extends BaseController
{

    protected $repository;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(CampaignRepository $repository)
	{
		$permission = Permission::where('name', 'LIKE', 'data-campaign-list%')
								->orWhere('name', 'LIKE', 'data-campaign-create%')
								->orWhere('name', 'LIKE', 'data-campaign-edit%')
								->orWhere('name', 'LIKE', 'data-campaign-delete%')
								->get();
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
			$hasPermissions = Permission::where('name', 'LIKE', 'data-bank-%')->get();

			$data = $this->repository->paginate($request);

			return $this->makeView('backoffice.masterdata.bank.index', compact('data', 'hasPermissions'));
		} catch (\Exception $exc) {
			 return $this->goTo500Page($exc);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return $this->makeView('backoffice.masterdata.bank.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request['id'] = $this->GenerateAutoNumber('dns_campaigns');

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

            return "Berhasil di tambahkan";
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = $this->decodeHash($id);
        $data = $this->repository->show($id);

        if (!$data->exists) {
            return redirect()->route('banks.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
        }

        return $this->makeView('backoffice.masterdata.bank.form', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $request['id'] = $id;

            if (!empty($request->file('image'))) {
				if (\File::exists(public_path('/assets/images/campaign' . $request->image))) {
                    \File::delete(public_path('/assets/images/campaign' . $request->image));
				}
				$image = time() . '.' .$request->file('image')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/images/campaign');
				$request->file('image')->move($destinationPath, $image);
			}

			if(empty($request->file('image'))) {
				$data = $this->repository->show($id);
				$request['image'] = $data->image;
			}

            if (!empty($request->file('background'))) {
				if (\File::exists(public_path('/assets/images/campaign' . $request->background))) {
                    \File::delete(public_path('/assets/images/campaign' . $request->background));
				}
				$background = time() . '.' .$request->file('background')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/images/campaign');
				$request->file('background')->move($destinationPath, $background);
			}

			if(empty($request->file('background'))) {
				$data = $this->repository->show($id);
				$request['background'] = $data->background;
			}

			$data = $this->repository->update($id, $request);

            return 'data berhasil di update';
        } catch (\Exception $exc) {
             return $this->goTo500Page($exc);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    // private function validator(Request $request)
	// {
	// 	return Validator::make($request->all(), [
    //             'name' => 'required',
    //             'image'        => 'image|mimes:jpg,png,jpeg,gif,svg|max:6000|unique:dns_banks,image,'.$request->id,
    //         ],[
	// 			'name.required' => ':attribute Wajib Diisi',
    //             'image.mimes'	 => 'Format :attribute Harus jpg,jpeg,png,bmp,tiff',
	// 		    'image.max'	     => ':attribute Maksimal :max Kb',
	// 		],[
	// 			'name' => 'Nama',
    //             'image' => 'Gambar',
	// 		]);
	// }
}
