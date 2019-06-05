<?php

namespace App\Http\Requests\Gallery;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Validation\Rule;

class ImageStoreFormRequest extends FormRequest
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

        $rules['description'] = 'required';

        $rules['category_id'] = ['required', Rule::notIn(['None'])];

        $rules['image'] = 'required|mimes:jpeg,bmp,png|max:10000';

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

        $messages['description.required'] = 'Image description is required.';

        $messages['category_id.not_in'] = 'Image category is required.';

        $messages['image.required'] = 'An image is required!.';

        $messages['image.mimes'] = 'Wrong file type.';
        $messages['image.max'] = 'The image size must be less than 10 MB.';

        return $messages;
    }
}
