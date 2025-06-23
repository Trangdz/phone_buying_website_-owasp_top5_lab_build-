<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|string|min:6|confirmed',
            // 'password_confirmation'=>'required|string|min:6|confirmed',
            'role'=>'required|in:0,1'
        ];
    }
    public function messages():array
    {
        return [
            'name.required'=>'Please enter username ',
            'email.required'=>'Please enter email ',
            'password.required'=>'Please enter password ',
            // 'password_confirmation.required'=>'Please enter confirm password ',
            'role.in'=>'You can choose one of two role',
            'email.min'=>'Password need use least 6 character',
            'email.unique'=>'That email have already exist',
            'password.confirmed'=>'Password and confirm password not match'
        ];
    }
}
