<?php

namespace App\Http\Requests\Frontend;

use App\Rules\RegexPhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostCheckoutRequest extends FormRequest
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
            'name' => 'required',
            'phone' => ['required', new RegexPhone()],
            'city_id' => ['required'],
            'district_id' => ['required'],
            'address' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Hãy nhập họ và tên',
            'phone.required' => 'Hãy nhập số điện thoại',
            'city_id.required' => 'Hãy chọn tỉnh/thành phố',
            'district_id.required' => 'Hãy chọn quận/huyện',
            'phone.required' => 'Hãy nhập số điện thoại',
            'address.required' => 'Hãy nhập địa chỉ cụ thể',
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
                $email = $this->input('email');
                if(!empty($email)){
                    $check = filter_var($email, FILTER_VALIDATE_EMAIL);
                    if(!$check){
                        $validator->errors()->add('email', 'Email không đúng định dạng');
                    }
                }
            });
        }
    }
}
