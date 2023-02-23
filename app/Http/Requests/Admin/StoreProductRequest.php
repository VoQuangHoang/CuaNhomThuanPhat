<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required',
            'category' => 'required',
            'image' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm không được bỏ trống.',
            'weight.required' => 'Nhập khối lượng của sản phẩm',
            'image.required' => 'Bạn chưa chọn hình ảnh đại diện.',
            'brand_id.required' => 'Bạn chưa chọn thương hiệu sản phẩm.',
            'price.required' => 'Bạn chưa nhập giá sản phẩm',
            'price.min' => 'Giá sản phẩm lớn hơn 1',
            'category.required' => 'Bạn chưa chọn danh mục sản phẩm.',
            'sku.required' => 'Mã sản phẩm không được bỏ trống',
            'sku.unique' => 'Mã sản phẩm này đã tồn tại trong hệ thống',
            'price_sale.lt' => 'Giá khuyến mãi nhỏ hơn giá hiện tại'
        ];
    }
}
