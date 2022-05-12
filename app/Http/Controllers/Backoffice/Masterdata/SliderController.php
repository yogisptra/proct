<?php

namespace App\Http\Controllers\Backoffice\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\DigiBase\Controller\BaseController;
use Spatie\Permission\Models\Permission;
use App\Repositories\SliderRepository;
use DB, File, Auth;

class SliderController extends BaseController
{

    protected $repository;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(SliderRepository $repository)
	{
		$permission = Permission::where('name', 'LIKE', 'data-slider-list%')
								->orWhere('name', 'LIKE', 'data-slider-create%')
								->orWhere('name', 'LIKE', 'data-slider-edit%')
								->orWhere('name', 'LIKE', 'data-slider-delete%')
								->get();
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
			$hasPermissions = Permission::where('name', 'LIKE', 'data-slider-%')->get();

			$data = $this->repository->paginate($request);

			return $this->makeView('backoffice.masterdata.slider.index', compact('data', 'hasPermissions'));
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
		return $this->makeView('backoffice.masterdata.slider.form');
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
            $validator = $this->validator($request);

			if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);

            $request['id'] = $this->GenerateAutoNumber('dns_sliders');
            $request['created_by'] = Auth::guard('web')->user()->name;

            if (!empty($request->file('image'))) {
				if (\File::exists(public_path('/assets/images/slider' . $request->image))) {
                    \File::delete(public_path('/assets/images/slider' . $request->image));
				}
				$image = time() . '.' .$request->file('image')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/images/slider');
				$request->file('image')->move($destinationPath, $image);
			}

			$data = $this->repository->store($request);

            if ($data->errorInfo != null || !$data->exists) {
                return redirect()->route('sliders.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }
    
            return redirect()->route('sliders.index')->with('success', 'Data berhasil ditambahkan');
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
            return redirect()->route('sliders.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
        }

        return $this->makeView('backoffice.masterdata.slider.form', compact('data'));
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
            $request['created_by'] = Auth::guard('web')->user()->name;
            $request['updated_by'] = Auth::guard('web')->user()->name;

            if (!empty($request->file('image'))) {
                $data = $this->repository->show($id);
				if (\File::exists(public_path('/assets/images/slider/' . $data->image))) {
                    \File::delete(public_path('/assets/images/slider/' . $data->image));
				}
				$image = time() . '.' .$request->file('image')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/images/slider/');
				$request->file('image')->move($destinationPath, $image);
			}

			if(empty($request->file('image'))) {
				$data = $this->repository->show($id);
				$request['image'] = $data->image;
			}

			$data = $this->repository->update($id, $request);

            if ($data->errorInfo != null || !$data->exists) {
                return redirect()->route('sliders.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }
    
            return redirect()->route('sliders.index')->with('success', 'Data berhasil ditambahkan');
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

	public function activeNonActive($id, $status)
	{
       	try {
            $id = $this->decodeHash($id);
			$activeNonActive = $this->repository->activeNonActive($id, $status);

            if (!$activeNonActive) {
                return redirect()->route('sliders.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

			return redirect()->route('sliders.index')->with('success', 'Data Berhasil diubah');
        } catch (\Exception $exc) {
             return $this->goTo500Page($exc);
        }
	}

    private function validator(Request $request)
	{
		return Validator::make($request->all(), [
                'name' => 'required',
                'link' 			=> 'required|max:255|url',
                'image'        => 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:2000',
            ],[
				'name.required' => ':attribute Wajib Diisi',
                'link.required' => ':attribute Wajib Diisi',
                'link.max'		=> ':attribute Melebihi :max Karakter',
                'image.mimes'	 => 'Format :attribute Harus jpg,jpeg,png,bmp,tiff,webp',
			    'image.max'	     => ':attribute Maksimal :max Kb',
			],[
				'name' => 'Nama',
                'image' => 'Gambar',
                'link' => 'Link',
			]);
	}
}
