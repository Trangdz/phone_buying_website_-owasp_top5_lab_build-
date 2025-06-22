<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TelePhoneRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role===1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'   => 'required|string|max:255',
            'price'  => 'required|numeric|min:0',
            'number' => 'required|integer|min:1',
            'brand'  => 'required|in:1,2,3,4',
            // 'image'  => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'image' => 'sometimes|nullable|file',
        ];
        
    }

    public function messages(): array
    {
        return [
        'name.required'   => 'Vui lòng nhập tên sản phẩm',
            'price.required'  => 'Bạn chưa nhập giá',
            'price.numeric'   => 'Giá phải là số',
            'number.required' => 'Số lượng không được để trống',
            'brand.in'        => 'Bạn phải chọn một hãng sản xuất',
            'image.image'     => 'Tệp tải lên phải là ảnh',
        ];
    }
}
