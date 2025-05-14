<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginFormRequest extends FormRequest
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
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスは必須です',
            'email.email' => 'メールアドレスの形式で入力してください',
            'password.required' => 'パスワードは必須です',
            'password.min' => 'パスワードは6文字以上で入力してください',
        ];
    }
} 