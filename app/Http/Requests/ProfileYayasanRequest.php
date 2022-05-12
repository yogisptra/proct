<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileYayasanRequest extends FormRequest
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
			'image'			=> 'image|mimes:jpg,png,jpeg,gif,svg|max:6000',
        ];
    }

    public function store(ProfileYayasanRequest $request)
    {
        // The incoming request is valid...

        // Retrieve the validated input data...
        $validated = $request->validated();
    }

    public function attributes()
    {
        return [
            'image'		=> 'Gambar',
        ];
    }

    public function messages()
    {
        return [
			'image.mimes'				=> 'Format :attribute Harus jpg,jpeg,png,bmp,tiff',
			'image.max'					=> ':attribute Maksimal :max Kb',
        ];
    }
}
