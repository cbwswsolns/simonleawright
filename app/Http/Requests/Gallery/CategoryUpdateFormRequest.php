<?php

namespace App\Http\Requests\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this råequest.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guard('admin')->check();
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }
}
