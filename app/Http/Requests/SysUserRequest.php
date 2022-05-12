<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SysUserRequest extends FormRequest
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
			'name' 				=> 'required|max:50',
            'email' 	=> [
				'required',
				'email',
				'max:50',
				Rule::unique('users', 'email')->ignore($this->user)
			],
			'password' 			=> 'same:confirm-password|min:3|max:50',
			'image'		=> 'image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];
    }

    public function store(SysUserRequest $request)
    {
        // The incoming request is valid...

        // Retrieve the validated input data...
        $validated = $request->validated();
    }

    public function attributes()
    {
        return [
            'name' 			=> 'Nama',
            'password' 	=> 'Password',
			'confirm-password'		=> 'Confirm Password',
            'email'		=> 'Email',
            'image'		=> 'Image'
        ];
    }

    public function messages()
    {
        return [
            'name.required' 			=> ':attribute Wajib Diisi',
            'name.max'		 			=> ':attribute Melebihi :max Karakter',
            'email.required' 			=> ':attribute Wajib Diisi',
            'email.max'		 			=> ':attribute Melebihi :max Karakter',
            'email.unique'				=> ':attribute Sudah Terdaftar',
            'email.email'				=> 'Format Penulisan :attribute Salah',
            'password.required' 		=> ':attribute Wajib Diisi',
            'password.min'				=> ':attribute Kurang dari :min Karakter',
            'password.max'				=> ':attribute Melebihi :max Karakter',
            'confirm-password.required' => ':attribute Wajib Diisi',
            'confirm-password.same'		=> ':attribute Harus Sama dengan Password',
			'image.mimes'				=> 'Format :attribute Harus jpg,jpeg,png,bmp,tiff',
			'image.max'					=> ':attribute Maksimal :max Kb',
        ];
    }
}
