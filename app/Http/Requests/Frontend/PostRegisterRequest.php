<?php

namespace App\Http\Requests\Frontend;

use App\Rules\RegexPhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostRegisterRequest extends FormRequest
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
            'email' => 'bail|required|email:rfc|unique:customer',
            'name' => 'bail|required|min:6|',
            'phone' => ['required', new RegexPhone(),'unique:customer'],
            'password' => 'required|string|min:8',
            'password_confirmation' => 'bail|required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được bỏ trống.',
            'email.unique' => 'Email đã được sử dụng',
            'email.email' => 'Email không đúng định dạng',
            'phone.required' => 'Số điện thoại không được bỏ trống',
            'phone.unique' => 'Số điện thoại đã được sử dụng',
            'name.required' => 'Tên không được bỏ trống',
            'password.required' => 'Mật khẩu không được bỏ trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 kí tự.',
            'password_confirmation.required' => 'Mật khẩu nhập lại không được bỏ trống.',
            'password_confirmation.same' => 'Giá trị xác nhận trong trường Mật khẩu không khớp.',
        ];
    }

    protected function failedValidation(Validator $validator) { 
        
        throw new HttpResponseException(response()->json([
                'success' => false,
                'errorMessage'=>$validator->messages()
            ])
        ); 
    }
}
