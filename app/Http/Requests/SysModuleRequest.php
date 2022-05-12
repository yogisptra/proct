<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SysModuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' 			=> [
					'required',
					'max:50',
					Rule::unique('sys_modules', 'name')->ignore($this->module)
				],
			'description'	=> 'required|max:250',
			'sequence'		=> 'required',
			'icon'			=> 'required|max:50',
			'enabled'		=> 'required'
        ];
    }

    public function store(SysMenuRequest $request)
    {
        // The incoming request is valid...

        // Retrieve the validated input data...
        $validated = $request->validated();
    }

    public function attributes()
    {
        return [
            'name' 			=> 'Nama',
            'description' 	=> 'Deskripsi',
			'sequence'		=> 'Urutan',
			'icon'			=> 'Ikon',
			'enabled'		=> 'Status'
        ];
    }

    public function messages()
    {
        return [
            'name.required' 			=> ':attribute Wajib Diisi',
            'name.max'		 			=> ':attribute Melebihi :max Karakter',
            'name.unique'				=> ':attribute Sudah Terdaftar',
            'description.required' 		=> ':attribute Wajib Diisi',
            'description.max' 	 		=> ':attributeMelebihi :max Karakter',
            'sequence.required' 		=> ':attribute Wajib Diisi',
            'icon.required'		 		=> ':attribute Wajib Diisi',
            'icon.max'					=> ':attribute Melebihi :max Karakter',
            'enabled.required' 			=> ':attribute Wajib Diisi',
        ];
    }
}
