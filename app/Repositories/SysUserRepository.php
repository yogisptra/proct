<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use App\DigiBase\Utilities\GenerateNumber;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Hash, Auth, DB, Cache;

class SysUserRepository extends Apprepository{
    protected $model;
    protected $role;

    public function __construct(User $model, Role $role)
    {
        $this->model = $model;
        $this->role = $role;
    }

    protected function setDataPayload(Request $request)
    {
        if(!empty($request->file('image'))){
			$image = time() . '.' .$request->file('image')->getClientOriginalExtension();
		}else if (isset($request['image'])){
			$image = $request['image'];
		}else {
			$image = null;
		}


		if(isset($request['password'])){
			if(strlen($request['password']) > 20){
				$password = $request['password'];
			}else{
				$password = Hash::make($request['password']);
			}
		}else {
			$password = null;
		}

        return [
            'id' 			=> isset($request['id']) ? $request->input('id') : null,
            'name' 			=> isset($request['name']) ? $request->input('name') : null,
            'email' 		=> isset($request['email']) ? $request->input('email') : null,
            'phone_number' 	=> isset($request['phone_number']) ? $request->input('phone_number') : null,
            'gender' 	    => isset($request['gender']) ? $request->input('gender') : null,
            'address' 	    => isset($request['address']) ? $request->input('address') : null,
            'image' 	    => $image,
            'password'	 	=> $password,
        ];
    }

    /**
     * get collection of items in paginate format.
     * 
     * @return Collection of items.
     */
    public function paginate(Request $request)
    {
       
        $data = $this->model
                    ->when(request()->search, function($query) {
                        $query->where('name', 'like', '%'.request()->search.'%');
                    })
                    ->orderBy('created_at','DESC')
                    ->paginate($request->input('limit', 15))
                    ->appends(request()->query());
         
        return $data;
    }

	public function getRole(){
        $data = NULL;
        DB::beginTransaction();
        try {
            $data = $this->role
                        //->where('id', '!=', '2020151101001')
                        ->where('enabled', 1)
                        ->orderBy('created_at','DESC')
                        ->get();
          

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }
        return $data;
    }

	public function roleWithoutSuperAdmin(){
        $data = NULL;
        DB::beginTransaction();
        try {
            $data = $this->role
                        ->where('id', '!=', '2020151101001')
                        ->where('enabled', 1)
                        ->orderBy('created_at','DESC')
                        ->get();
          

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }
        return $data;
    }

	public function updatePassword(Request $request){
        $user = NULL;
        DB::beginTransaction();
        try {
            $user =  $this->model->where('id', $request->id)->first();
            $user->update([
                'password' => Hash::make($request['password'])
            ]);

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $user = $th;
        }
        return $user;
	}

}