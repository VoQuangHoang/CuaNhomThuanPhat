<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SendProductReviewRequest extends FormRequest
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
            'content' => 'required|max:300',
            'name' => 'required|max:50',
            'email' => 'required|max:50|email',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => 'Nhập nội dung đánh giá',
            'content.max' => 'Nội dung đánh giá không quá 300 ký tự',
            'name.required' => 'Vui lòng nhập họ và tên',
            'name.max' => 'Nội dung đánh giá không quá 50 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Nhập sai định dạng email',
            'email.max' => 'Email không quá 50 ký tự',
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
