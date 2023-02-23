<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class StoreAdsRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255', 'unique:ads'],
        ];
    }

    public function withValidator(Validator $validator){
        if(!$validator->failed()){
            $validator->after(function ($validator) {
                $image = $this->input('image');
                $embed = $this->input('embed');
                if($this->input('type') == 'BANNER'){
                    if(empty($image)){
                        $validator->errors()->add('email', 'The image field is required.');
                    }
                }
                if($this->input('type') == 'EMBED'){
                    if(empty($embed)){
                        $validator->errors()->add('email', 'The embed field is required.');
                    }
                }
            });
        }
    }
}
