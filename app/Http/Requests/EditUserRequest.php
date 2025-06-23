<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('id'),
            'role'  => 'required|in:user,admin',
        ];
    
        // ✅ Nếu có nhập password HOẶC password_confirmation thì kiểm tra đầy đủ
        if ($this->filled('password') || $this->filled('password_confirmation')) {
            $rules['password'] = ['required', 'string', 'min:6', 'confirmed'];
        }
    
        return $rules;
    }
    

    public function messages(): array
    {
        return [
            'password.required'     => 'Vui lòng nhập mật khẩu nếu muốn đổi.',
            'password.min'          => 'Mật khẩu phải ít nhất 6 ký tự.',
            'password.confirmed'    => 'Mật khẩu xác nhận không trùng khớp.',
        ];
    }
    
}
