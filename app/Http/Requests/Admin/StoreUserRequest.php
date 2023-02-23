<?php

namespace App\Http\Requests\Admin;

use App\Rules\RegexPhone;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            // 'user_name'     => 'required|unique:users,user_name|regex:/^[A-Za-z0-9_\.]{5,32}$/',
            'name'          => 'required',
            'role_id'       => 'required',
            'phone'         => ['required',new RegexPhone(),'unique:users,phone'],
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'repassword'    => 'required|same:password'
        ];
    }

    public function messages()
    {
        return [
            'role_id.required'      => 'Chọn vai trò của người dùng',
        ];
    }
}
