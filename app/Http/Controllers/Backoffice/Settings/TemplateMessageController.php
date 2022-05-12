<?php

namespace App\Http\Controllers\Backoffice\Settings;

use App\DigiBase\Controller\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Repositories\TemplateMessageRepository;
use DB, File, Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class TemplateMessageController extends BaseController
{

    protected $repository;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(TemplateMessageRepository $repository)
	{
		$permission = Permission::where('name', 'LIKE', 'data-template_message-list%')
								->orWhere('name', 'LIKE', 'data-template_message-create%')
								->orWhere('name', 'LIKE', 'data-template_message-edit%')
								->orWhere('name', 'LIKE', 'data-template_message-delete%')
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
			$hasPermissions = Permission::where('name', 'LIKE', 'data-template_message-list%')
								->orWhere('name', 'LIKE', 'data-template_message-create%')
								->orWhere('name', 'LIKE', 'data-template_message-edit%')
								->orWhere('name', 'LIKE', 'data-template_message-delete%')
								->get();

			$data = $this->repository->paginate($request);
			return $this->makeView('backoffice.settings.message.index', compact('data', 'hasPermissions'));
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
		return $this->makeView('backoffice.settings.message.form');
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
            
            $request['created_by'] = Auth::guard('web')->user()->name;
            $request['id'] = strtoupper(str_replace(' ', '_', $request->name));
			$data = $this->repository->store($request);

            if ($data->errorInfo != null || !$data->exists) {
                return redirect()->route('template_messages.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return redirect()->route('template_messages.index')->with('success', 'Data berhasil ditambahkan');
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
        try {
            $data = $this->repository->show($id);

            if ($data->errorInfo != null || !$data->exists) {
                return redirect()->route('template_messages.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return $this->makeView('backoffice.settings.message.show', compact('data'));
        } catch (\Exception $exc) {
             return $this->goTo500Page($exc);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $data = $this->repository->show($id);

            if ($data->errorInfo != null || !$data->exists) {
                return redirect()->route('template_messages.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return $this->makeView('backoffice.settings.message.form', compact('data'));
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
    public function update(Request $request, $id)
    {
        try {
            $validator = $this->validator($request);

			if ($validator->fails()) return redirect()->back()->withInput()->withErrors($validator);
            $getData = $this->repository->show($id);

            $request['created_by'] = $getData->created_by;
            $request['updated_by'] = Auth::guard('web')->user()->name;
			$request['id'] = $id;
            
			$data = $this->repository->update($id, $request);

            if ($data->errorInfo != null || !$data->exists) {
                return redirect()->route('template_messages.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return redirect()->route('template_messages.index')->with('success', 'Data berhasil diubah');
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
			$activeNonActive = $this->repository->activeNonActive($id, $status);
            
            if (!$activeNonActive) {
                return redirect()->back()->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

			return redirect()->route('template_messages.index')->with('success', 'Data Berhasil diubah');
        } catch (\Exception $exc) {
             return $this->goTo500Page($exc);
        }
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
            $request->file('upload')->storeAs('public/template_message', $filenametostore);
 
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/template_message/'.$filenametostore);
            $msg = 'Image successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
             
            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }

    private function validator(Request $request)
	{
        return Validator::make($request->all(), [
            'name' => 'required',
            'message' => 'required',
            'type' => 'required',
        ],[
            'name' => ':attribute Wajib Diisi',
            'message.required' => ':attribute Wajib Diisi',
            'type.required' => ':attribute Wajib Diisi',
        ],[
            'name' => 'Nama',
            'message' => 'Pesan',
            'type' => 'Tipe',
        ]);
	}
}
