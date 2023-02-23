<?php

namespace App\Http\Requests\Frontend;

use App\Rules\RegexPhone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostUserAddressRequest extends FormRequest
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
            'phone' => ['required', new RegexPhone()],
            'name' => 'bail|required',
            'type' => 'bail|required',
            'city_id' => 'bail|required',
            'district_id' => 'bail|required',
            'ward_id' => 'bail|required',
            'address' => 'bail|required',
            'is_default' => 'bail',
        ];
    }

    public function messages()
    {
        return [
            'phone.unique' => 'Số điện thoại không đúng định dạng',
            'name.required' => 'Tên không được bỏ trống',
            'type.required' => 'Loại địa chỉ không được bỏ trống.',
            'city_id.required' => 'Tỉnh/Thành phố không được bỏ trống.',
            'district_id.required' => 'Quận/Huyện không được bỏ trống.',
            'ward_id.required' => 'Phường/Xã không được bỏ trống.',
            'address.required' => 'Địa chỉ không được bỏ trống.',
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
