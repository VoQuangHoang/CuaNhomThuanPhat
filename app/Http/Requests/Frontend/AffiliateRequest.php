<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class AffiliateRequest extends FormRequest
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
            'request_type' => 'required',
            'bank_name' => 'required_if:request_type,bank_tranfer|max:100',
            'bank_number' => 'required_if:request_type,bank_tranfer|max:50',
            'holder_name' => 'required_if:request_type,bank_tranfer|max:100',
        ];
    }

    public function messages()
    {
        return [
            'bank_name.required_if' => 'Ngân hàng không được để trống khi chọn hình thức rút tiền: Chuyển khoản ngân hàng',
            'bank_number.required_if' => 'Số tài khoản không được để trống khi chọn hình thức rút tiền: Chuyển khoản ngân hàng',
            'holder_name.required_if' => 'Tên tài khoản không được để trống khi chọn hình thức rút tiền: Chuyển khoản ngân hàng',
        ];
    }
}
