<?php

namespace App\Http\Controllers\Backoffice\Masterdata;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\DigiBase\Controller\BaseController;
use Spatie\Permission\Models\Permission;
use App\Repositories\FaqDescriptionRepository;
use DB, File, Auth;

class FAQDescriptionController extends BaseController
{

    protected $repository;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(FaqDescriptionRepository $repository)
	{
		$permission = Permission::where('name', 'LIKE', 'data-faq_description-list%')
								->orWhere('name', 'LIKE', 'data-faq_description-create%')
								->orWhere('name', 'LIKE', 'data-faq_description-edit%')
								->orWhere('name', 'LIKE', 'data-faq_description-delete%')
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
			$hasPermissions = Permission::where('name', 'LIKE', 'data-faq_description-%')->get();

			$data = $this->repository->paginate($request);

			return $this->makeView('backoffice.masterdata.faq_description.index', compact('data', 'hasPermissions'));
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
        $faqCategory = $this->repository->getFAQCategory();

		return $this->makeView('backoffice.masterdata.faq_description.form', compact('faqCategory'));
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

            $request['id'] = $this->GenerateAutoNumber('dns_faq_descriptions');
            $request['created_by'] = Auth::guard('web')->user()->name;

			$data = $this->repository->store($request);

            if ($data->errorInfo != null || !$data->exists) {
                return redirect()->route('faq_descriptions.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }
    
            return redirect()->route('faq_descriptions.index')->with('success', 'Data berhasil ditambahkan');
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
        $id = $this->decodeHash($id);
        $data = $this->repository->show($id);

        return $this->makeView('backoffice.masterdata.faq_description.show', compact('data'));
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
        $faqCategory = $this->repository->getFAQCategory();

        if (!$data->exists) {
            return redirect()->route('faq_descriptions.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
        }

        return $this->makeView('backoffice.masterdata.faq_description.form', compact('data', 'faqCategory'));
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
            $request['updated_by'] = Auth::guard('web')->user()->name;

			$data = $this->repository->update($id, $request);

            if ($data->errorInfo != null || !$data->exists) {
                return redirect()->route('faq_descriptions.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }
    
            return redirect()->route('faq_descriptions.index')->with('success', 'Data berhasil ditambahkan');
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
                return redirect()->route('faq_descriptions.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

			return redirect()->route('faq_descriptions.index')->with('success', 'Data Berhasil diubah');
        } catch (\Exception $exc) {
             return $this->goTo500Page($exc);
        }
	}

    private function validator(Request $request)
	{
		return Validator::make($request->all(), [
                'question' => 'required',
                'keyword' => 'required',
                'answer' => 'required',
            ],[
				'question.required' => ':attribute Wajib Diisi',
                'keyword.required' => ':attribute Wajib Diisi',
                'answer' => ':attribute Wajib Diisi',
			],[
				'question' => 'Pertanyaan',
                'keyword' => 'Kata Kunci',
                'answer'   => 'Jawaban'
			]);
	}

    public function upload(Request $request)
    {
        if($request->hasFile('upload')) {
            //get filename with extension
            $filenamewithextension = $request->file('upload')->getClientOriginalName();
      
            //get filename without extension
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
      
            //get file extension
            $extension = $request->file('upload')->getClientOriginalExtension();
      
            //filename to store
            $filenametostore = $filename.'_'.time().'.'.$extension;
      
            //Upload File
            $request->file('upload')->storeAs('public/faq_description', $filenametostore);
 
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/faq_description/'.$filenametostore);
            $msg = 'Image successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
             
            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }
}
