<?php

namespace App\Http\Requests\Frontend;

use App\Rules\RegexPhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCustomerRequest extends FormRequest
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
            'email' => 'bail|required|unique:customer',
            'phone' => ['required', new RegexPhone(),'unique:customer'],
            'name' => 'bail|required',
            'avatar' => 'bail|mimes:jpeg,jpg,png|max:10000|nullable',
            'password' => 'bail|required|string|min:8',
            'password_confirmation' => 'bail|required|same:password',
            'customer_role_id' => 'bail|required'
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
            'name.required' => 'Họ và tên không được bỏ trống',
            'password.required' => 'Mật khẩu không được bỏ trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 kí tự.',
            'password_confirmation.required' => 'Nhập lại mật khẩu không được bỏ trống.',
            'password_confirmation.same' => 'Mật khẩu không đúng.',
            'customer_role_id.required' => 'Chọn loại tài khoản'
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
