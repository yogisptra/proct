<?php

namespace App\Http\Controllers\Backoffice\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileYayasanRequest;
use App\DigiBase\Controller\BaseController;
use App\Models\ProfileYayasan;
use Spatie\Permission\Models\Permission;
use App\Repositories\ProfileYayasanRepository;
use DB, Auth;

class ProfileYayasanController extends BaseController
{
    protected $repository;
	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	function __construct(ProfileYayasanRepository $repository)
	{
		$permission = Permission::where('name', 'LIKE', 'profile-yayasan-%')->get();
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
            $hasPermissions = Permission::where('name', 'LIKE', 'profile-yayasan-%')->get();
            $profile = $this->repository->show('2020151001001');

            $id = $profile->id;
            
            return redirect()->route('profile-yayasan.show', $id);

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
        try {
			return $this->makeView('backoffice.settings.profileyayasan.create');
		} catch (\Exception $exc) {
			 return $this->goTo500Page($exc);
		}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfileYayasanRequest $request)
    {

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
            $staticPage = isset($data->description) ? json_decode($data->description) : 'null';
            $address = isset($data->address) ? json_decode($data->address) : 'null';
            $phone_number = isset($data->phone_number) ? json_decode($data->phone_number) : 'null';
            $email = isset($data->email) ? json_decode($data->email) : 'null';
            $website = isset($data->website) ? json_decode($data->website) : 'null';
            $social_media = isset($data->social_media) ? json_decode($data->social_media) : 'null';

            $staticPage = [
                'profile' => ($staticPage->profile) ?? '-',
                'visi' => ($staticPage->visi) ?? '-',
                'misi' => ($staticPage->misi) ?? '-',
                'sejarah' => ($staticPage->sejarah) ?? '-',
                'manajemen' => ($staticPage->manajemen) ?? '-',
                'legalitas' => ($staticPage->legalitas) ?? '-',
                'termcondition' => ($staticPage->termcondition) ?? '-',
                'termfundraiser' => ($staticPage->termfundraiser) ?? '-',
                'termcorporate' => ($staticPage->termcorporate) ?? '-',
                'termpersonal' => ($staticPage->termpersonal) ?? '-',
                'termcampaignerpersonal' => ($staticPage->termcampaignerpersonal) ?? '-',
                'termcampaignercorporate' => ($staticPage->termcampaignercorporate) ?? '-',
                'privacy' => ($staticPage->privacy) ?? '-',
            ];

            $address = [
                'address1' => ($address->address1) ?? '-',
                'address2' => ($address->address2) ?? '-',
            ];

            $phone_number = [
                'phone_1' => ($phone_number->phone_1) ?? '-',
                'phone_2' => ($phone_number->phone_2) ?? '-',
            ];

            $email = [
                'email1' => ($email->email1) ?? '-',
                'email2' => ($email->email2) ?? '-',
            ];

            $website = [
                'website1' => ($website->website1) ?? '-',
                'website2' => ($website->website2) ?? '-',
            ];

            $social_media = [
                'facebook' => ($social_media->facebook) ?? '-',
                'instagram' => ($social_media->instagram) ?? '-',
                'youtube' => ($social_media->youtube) ?? '-',
            ];

            
            if (!$data) {
                return redirect()->route('profile-yayasan.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return $this->makeView('backoffice.settings.profileyayasan.create', compact('data', 'staticPage', 'address', 'phone_number', 'email', 'website', 'social_media'));
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
            $staticPage = json_decode($data->description);
            $address = json_decode($data->address);
            $phone_number = json_decode($data->phone_number);
            $email = json_decode($data->email);
            $website = json_decode($data->website);
            $social_media = json_decode($data->social_media);

            $staticPage = [
                'profile' => ($staticPage->profile) ?? '-',
                'visi' => ($staticPage->visi) ?? '-',
                'misi' => ($staticPage->misi) ?? '-',
                'sejarah' => ($staticPage->sejarah) ?? '-',
                'manajemen' => ($staticPage->manajemen) ?? '-',
                'legalitas' => ($staticPage->legalitas) ?? '-',
                'termcondition' => ($staticPage->termcondition) ?? '-',
                'termfundraiser' => ($staticPage->termfundraiser) ?? '-',
                'termcorporate' => ($staticPage->termcorporate) ?? '-',
                'termpersonal' => ($staticPage->termpersonal) ?? '-',
                'termcampaignerpersonal' => ($staticPage->termcampaignerpersonal) ?? '-',
                'termcampaignercorporate' => ($staticPage->termcampaignercorporate) ?? '-',
                'privacy' => ($staticPage->privacy) ?? '-',
            ];

            $address = [
                'address1' => ($address->address1) ?? '-',
                'address2' => ($address->address2) ?? '-',
            ];

            $phone_number = [
                'phone_1' => ($phone_number->phone_1) ?? '-',
                'phone_2' => ($phone_number->phone_2) ?? '-',
            ];

            $email = [
                'email1' => ($email->email1) ?? '-',
                'email2' => ($email->email2) ?? '-',
            ];

            $website = [
                'website1' => ($website->website1) ?? '-',
                'website2' => ($website->website2) ?? '-',
            ];

            $social_media = [
                'facebook' => ($social_media->facebook) ?? '-',
                'instagram' => ($social_media->instagram) ?? '-',
                'youtube' => ($social_media->youtube) ?? '-',
            ];


            if (!$data->exists) {
                return redirect()->route('profile-yayasan.index')->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }

            return $this->makeView('backoffice.settings.profileyayasan.create', compact('data', 'staticPage', 'address', 'phone_number', 'email', 'website', 'social_media'));
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
            $request['id'] = $id;

            if (!empty($request->file('image_url'))) {
                $data = $this->repository->show($id);
				if (\File::exists(public_path('/assets/images/profileyayasan' . $data->image_url))) {
                    \File::delete(public_path('/assets/images/profileyayasan' . $data->image_url));
				}
				$image = time() . '.' .$request->file('image_url')->getClientOriginalExtension();
				$destinationPath = public_path('/assets/images/profileyayasan');
				$request->file('image_url')->move($destinationPath, $image);
			}

			if(empty($request->file('image_url'))) {
				$data = $this->repository->show($id);
				$request['image_url'] = $data->image_url;
			}


            $data = $this->repository->update($id, $request);
    
            if ($data->errorInfo != null || !$data->exists) {
                return redirect()->route('profile-yayasan.show', $id)->with('error', 'Terjadi kesalahan saat input coba ulangi lagi');
            }
    
            return redirect()->route('profile-yayasan.show', $id)->with('success', 'Profile Yayasan Berhasil diubah');
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
        try {
			$delete = $this->repository->delete($id);

			return redirect()->route('profile-yayasan.index')->with('success', 'Profile Yayasan Berhasil dihapus');
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
            $request->file('upload')->storeAs('public/profile-yayasan', $filenametostore);
 
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/profile-yayasan/'.$filenametostore);
            $msg = 'Image successfully uploaded';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
             
            // Render HTML output
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }
}
