<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PermissionRequest extends FormRequest
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
            'name' 	=> [
				'required',
				'max:50',
				Rule::unique('permissions', 'name')->ignore($this->permission)
			]
        ];
    }

    public function store(SysAdminModel $request)
    {
        // The incoming request is valid...

        // Retrieve the validated input data...
        $validated = $request->validated();
    }

    public function attributes()
    {
        return [
            'name' 			=> 'Nama',
        ];
    }

    public function messages()
    {
        return [
            'name.required' 			=> ':attribute Wajib Diisi',
            'name.max'		 			=> ':attribute Melebihi :max Karakter',
            'name.unique'				=> ':attribute Sudah Terdaftar',
        ];
    }
}
