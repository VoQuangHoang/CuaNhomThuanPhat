<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddCartProductRequest extends FormRequest
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
            //
        ];
    }
    public function messages()
    {
        return [
            //
        ];
    }

    protected function failedValidation(Validator $validator) { 
        
        throw new HttpResponseException(response()->json(
            [
                'success' => false,
                'errorMessage'=>$validator->messages()
            ]
            )
        ); 
    }

    public function withValidator(Validator $validator){
        if(!$validator->failed()){
            $validator->after(function ($validator) {
                $attr = $this->input('product_attributes_id');
                if(!empty($attr) && $attr == 'chon'){
                    $validator->errors()->add('product_attributes_id', 'Chọn loại sản phẩm');
                }
            });
        }
    }
}
