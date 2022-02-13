<?php

namespace App\Http\Requests;

use App\Rules\AlphaNumHalf;
use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationFormRequest extends FormRequest
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
            'parentName'   => ['required', 'string', 'max:255'],
            'email'        => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'     => ['required', new AlphaNumHalf, 'min:8', 'confirmed'],
            'childName'    => ['required', 'string', 'max:255'],
            'age'          => ['required', 'integer'],
            'gender'       => ['required', 'string'],
            'diagnosis'    => ['nullable', 'string', 'max:255'],
            'childName2'   => ['nullable', 'string', 'max:255'],
            'age2'         => ['nullable', 'integer'],
            'gender2'      => ['nullable', 'string', 'max:255'],
            'diagnosis2'    => ['nullable', 'string', 'max:255'],
            'address'      => ['required', 'string', 'max:255'],
            'coursePlan'   => ['required', 'integer'],
            'introduction' => ['nullable', 'string', 'max:255'],
            'consaltation' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'parentName.required'              => '保護者氏名をご入力ください',
            'parentName.string'                => '文字でご入力ください',
            'parentName.max'                => '文字数が多いです',

            'email.required'           => 'メールアドレスをご入力ください',
            'email.email'              => 'メールアドレス形式でご入力ください',
            'parentName.max'                => '文字数が多いです',
            'email.unique'             => '入力したメールアドレスは既に登録されています',

            'password.required'        => 'パスワードをご入力ください',
            'password.min'             => '8文字以上でご入力ください',
            'password.confirmed'       => 'パスワードと確認パスワードが異なります',

            'childName.required'              => '利用児氏名をご入力ください',
            'childName.string'                => '文字でご入力ください',
            'childName.max'                => '文字数が多いです',

            'age.required'              => '年齢をご入力ください',
            'age.integer'               => '半角数字でご入力ください',

            'gender.required'              => '性別をご入力ください',
            'gender.string'                => '文字でご入力ください',

            'diagnosis.string'                => '文字でご入力ください',
            'diagnosis.max'              => '文字数が多いです',

            'childName2.string'                => '文字でご入力ください',
            'childName2.max'                => '文字数が多いです',

            'age2.integer'               => '半角数字でご入力ください',

            'gender2.string'                => '文字でご入力ください',

            'diagnosis2.string'                => '文字でご入力ください',
            'diagnosis2.max'              => '文字数が多いです',

            'address.required'              => '住所をご入力ください',
            'address.string'                => '文字でご入力ください',

            'coursePlan.required'              => 'コースプランをご入力ください',
            'coursePlan.integer'               => '半角数字でご入力ください',

            'introduction.string'                => '文字でご入力ください',
            'introduction.max'                => '文字数が多いです',

            'consaltation.string'                => '文字でご入力ください',

        ];
    }
}
