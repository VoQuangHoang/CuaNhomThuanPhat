<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreSpaRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required'],
            'content' => ['required', 'string'],
            'image' => ['required'],
            'meta_title' => ['max:120'],
            'meta_description' => ['max:360'],
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => 'Chọn một danh mục',
            'meta_title.max' => 'Thẻ meta title không quá 120 ký tự',
            'meta_description.max' => 'Thẻ meta title không quá 360 ký tự'
        ];
    }
}
