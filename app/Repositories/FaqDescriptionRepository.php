<?php

namespace App\Repositories;

use App\DigiBase\Repositories\AppRepository;
use App\DigiBase\Utilities\GenerateNumber;
use App\Models\FAQCategory;
use App\Models\FAQDescription;
use Illuminate\Http\Request;
use Auth;

class FaqDescriptionRepository extends Apprepository{
    protected $model, $faqCategory;

    public function __construct(FAQDescription $model, FAQCategory $faqCategory)
    {
        $this->model = $model;
        $this->faqCategory = $faqCategory;
    }

    protected function setDataPayload(Request $request)
    {
        $enabled = 0;
        if($request['enabled'] == true){
            $enabled = 1;
        }

        return [
            'id' 			    => isset($request['id']) ? $request->input('id') : null,
            'faq_categories_id' => isset($request['faq_categories_id']) ? $request->input('faq_categories_id') : null,
            'type' 			=> isset($request['type']) ? $request->input('type') : null,
            'question' 	        => isset($request['question']) ? $request->input('question') : null,
            'keyword'           => isset($request['keyword']) ? $request->input('keyword') : null,
            'answer'            => isset($request['answer']) ? $request->input('answer') : null,
            'created_by'        => isset($request['created_by']) ? $request->input('created_by') : null,
            'updated_by'        => isset($request['updated_by']) ? $request->input('updated_by') : null,
            'enabled' 	        => $enabled,
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
        $data = $this->model
                    ->when(request()->search, function($query) {
                        $query->where('keyword', 'like', '%'.request()->search.'%');
                        $query->OrWhere('question', 'like', '%'.request()->search.'%');
                    })
                    ->orderBy('created_at','DESC')
                    ->paginate($request->input('limit', 15))
                    ->appends(request()->query());
         
        return $data;
    }

    public function getFAQCategory()
    {
        return $this->faqCategory->where('enabled', 1)->orderBy('created_at', 'DESC')->get();
    }


}
