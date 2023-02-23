<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponsRequest extends FormRequest
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
            'code' => 'required|unique:coupons',
            'name' => 'required',
            'value' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Mã khuyến mãi không được bỏ trống',
            'code.unique' => 'Mã khuyến mãi đã tồn tại',
            'name.required' => 'Tiêu đề mã giảm giá không được bỏ trống',
            'value.required' => 'Giá trị giảm không được bỏ trống',
        ];
    }
}
