<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreGameRequest extends FormRequest
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
            'name' => ['required'],
            'publisher' => ['required'],
            'mod' => ['required'],
            'image' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            
        ];
    }

    public function withValidator(Validator $validator){
        if(!$validator->failed()){
            $validator->after(function ($validator) {
                $trending = $this->input('trending');
                if(!empty($trending) && $trending == 1){
                    $image_trending = $this->input('image_trending');
                    if(empty($image_trending)){
                        $validator->errors()->add('trending', 'The trending banner field is required.');
                    }
                }
            });
        }
    }
}
