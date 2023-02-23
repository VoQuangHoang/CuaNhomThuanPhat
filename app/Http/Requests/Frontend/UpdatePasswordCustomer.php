<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePasswordCustomer extends FormRequest
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
            'password' => 'bail|required',
            'password_new' => 'bail|required|min:8',
            'password_new_confirmation' => 'bail|required|min:8|same:password_new',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'Mật khẩu hiện tại không được bỏ trống.',
            'password.unique' => 'Mật khẩu hiện tại không đúng.',
            'password_new.required' => 'Mật khẩu mới không được bỏ trống.',
            'password_new.min' => 'Mật khẩu mới quá ngắn.',
            'password_new_confirmation.required' => 'Mật khẩu nhập lại không được bỏ trống.',
            'password_new_confirmation.min' => 'Mật khẩu nhập lại quá ngắn.',
            'password_new_confirmation.same' => 'Mật khẩu nhập lại không giống mật khẩu mới.',
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
}
