<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\SysRole;
use Illuminate\Http\Request;
use Auth, DB, Cache;

class RoleRepository extends Apprepository{
    protected $model;

    public function __construct(SysRole $model)
    {
        $this->model = $model;
    }

    protected function setDataPayload(Request $request)
    {

        return [
            'id' 			=> isset($request['id']) ? $request->input('id') : null,
            'name' 			=> isset($request['name']) ? $request->input('name') : null,
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

}