<?php

namespace App\Http\Requests\Frontend;

use App\Rules\RegexPhone;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateCustomerRequest extends FormRequest
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
            'email' => 'bail|required|unique:customer,email,'. Auth::guard('customer')->id(),
            'phone' => ['required', new RegexPhone(),'unique:customer,phone,'. Auth::guard('customer')->id()],
            'name' => 'bail|required',
            'avatar' => 'bail|mimes:jpeg,jpg,png|max:10000|nullable',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được bỏ trống.',
            'email.unique' => 'Email đã được sử dụng',
            'phone.required' => 'Số điện thoại không được bỏ trống',
            'phone.unique' => 'Số điện thoại đã được sử dụng',
            'name.required' => 'Tên không được bỏ trống',
            'avatar.mimes' => 'Chỉ hỗ trợ định dạng file jpeg, jpg, png.',
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
