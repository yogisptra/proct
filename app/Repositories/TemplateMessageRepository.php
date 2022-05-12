<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use App\DigiBase\Utilities\AutoNumber;
use App\Models\TemplateMessage;
use Auth, DB, Cache;
use Illuminate\Http\Request;

class TemplateMessageRepository extends Apprepository{
    use AutoNumber;
    protected $model;

    public function __construct(TemplateMessage $model)
    {
        $this->model = $model;
    }

    protected function setDataPayload(Request $request)
    {
        $enabled = 0;
        if($request['enabled'] == true){
            $enabled = 1;
        }

        return [
            'id' 			=> isset($request['id']) ? $request->input('id') : null,
            'name' 			=> isset($request['name']) ? $request->input('name') : null,
            'message' 			=> isset($request['message']) ? $request->input('message') : null,
            'description'   => isset($request['description']) ? $request->input('description') : null,
            'type'   => isset($request['type']) ? $request->input('type') : null,
            'created_by'    =>  isset($request['created_by']) ? $request->input('created_by') : null,
            'updated_by'    =>  isset($request['updated_by']) ? $request->input('updated_by') : null,
            'enabled' 	    => $enabled,
        ];
    }

    // Payload for multiplePost with Relation
    // protected function setDataPayloadMultiple(Request $request)
    // {
    //  $enabled = 0;
    //  if($request['enabled'] == true){
    //      $enabled = 1;
    //  }

    //  return [
    //        'id' 			=> isset($request['id']) ? $request->input('id') : null,
    //        'name' 			=> isset($request['name']) ? $request->input('name') : null,
    //        'description'   => isset($request['description']) ? $request->input('description') : null,
    //        'created_by'    => isset($request['created_by']) ? $request->input('created_by') : null,
    //       'updated_by'    => isset($request['updated_by']) ? $request->input('updated_by') : null,
    //        'enabled' 	    => $enabled,
    //    ];
    // }

    public function paginate(Request $request)
    {
        $data = NULL;
        DB::beginTransaction();
        try {
            $data = $this->model->when(request()->message, function($query) {
                                $query->where('message', 'LIKE', '%' . request()->input('message') . '%');
                            })
                            ->when(request()->description, function($query) {
                                $query->where('description', 'LIKE', '%' . request()->input('description') . '%');
                            })
                            ->orderBy('created_at', 'ASC')
                            ->paginate($request->input('limit', 10))
                            ->appends(request()->query());

            Cache::flush();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $data = $th;
        }
        return $data;  
    }

    public function getAvailable()
    {
        return $this->model->where('enabled', 1)->get();
    }

    public function getDataById($id)
    {
        return $this->model->where('enabled', 1)->where('id', $id)->first();
    }

}
