<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionRepository extends Apprepository{
    protected $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }
    
    /**
     * get collection of items in paginate format.
     * 
     * @return Collection of items.
     */
    public function paginate(Request $request)
    {
        $data = NULL;
        DB::beginTransaction();
        try {
            $data = $this->model->orderBy('created_at','DESC')->paginate($request->input('limit', 15));
            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }
        return $data;
    }

    protected function setDataPayload(Request $request)
    {
        return [
            'id' 			=> isset($request['id']) ? $request->input('id') : null,
            'name' 			=> isset($request['name']) ? $request->input('name') : null,
        ];
    }

}