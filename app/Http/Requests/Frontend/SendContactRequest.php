<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class SendContactRequest extends FormRequest
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
            'name' => ['required'],
            'email' => ['required', 'email'],
            'subject' => ['required'],
            'message' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Họ tên không được bỏ trống.',
            'email.required' => 'Mail không được bỏ trống.',
            'subject.required' => 'Chủ đề không được bỏ trống.',
            'message.required' => 'Nội dung không được bỏ trống.',
            'email.email' => 'Vui lòng nhập đúng định dạng email.'
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

    // public function withValidator(Validator $validator){
    //     if(!$validator->failed()){
    //         $validator->after(function ($validator) {
    //             $email = $this->input('email');
    //             if(!empty($email)){
    //                 $check = filter_var($email, FILTER_VALIDATE_EMAIL);
    //                 if(!$check){
    //                     $validator->errors()->add('email', 'Email không đúng định dạng');
    //                 }
    //             }
    //         });
    //     }
    // }
}
