<?php

namespace App\Http\Requests\Gallery;

use Illuminate\Foundation\Http\FormRequest;

class ImageUpdateFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
        $rules = [];

        $rules['title']  = 'required|string';

        $rules['category_id'] = 'required';

        $rules['description'] = 'required';

        $rules['image'] = 'mimes:jpeg,bmp,png|max:10000';

        return $rules;
    }


    /**
     * Get the messages corresponding to the validation rules.
     *
     * @return array
     */
    public function messages()
    {
        $messages = [];

        $messages['title.required'] = 'Name of image is required.';

        $messages['category_id.not_in'] = 'Image category is required.';

        $messages['description.required'] = 'Image description is required.';

        $messages['image.mimes'] = 'Wrong file type.';
        $messages['image.max'] = 'The image size must be less than 10 MB.';

        return $messages;
    }
}
