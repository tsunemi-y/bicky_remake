<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'parentName'        => 'required|string|max:255',
            'parentNameKana'    => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users,email',
            'tel'               => 'required|string|max:20',
            'password'          => 'required|string|min:8|confirmed',
            'postCode'          => 'required|string|max:8',
            'address'           => 'required|string|max:255',
            // 子ども情報を配列で受け取る
            'childName'         => 'required|array|min:1',
            'childName.*'       => 'required|string|max:255',
            'childNameKana'     => 'required|array|min:1',
            'childNameKana.*'   => 'required|string|max:255',
            'age'               => 'required|array|min:1',
            'age.*'             => 'required|numeric',
            'gender'            => 'required|array|min:1',
            'gender.*'          => 'required|string|in:男の子,女の子',
            'diagnosis'         => 'nullable|array',
            'diagnosis.*'       => 'nullable|string|max:255',
            // その他
            'introduction'      => 'nullable|string|max:255',
            'consultation'      => 'nullable|string',
            'lineConsultation'  => 'nullable|boolean',
        ];

        return $rules;
    }

    /**
     * Customize the validation messages.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'parentName.required'           => '保護者氏名は必須です。',
            'parentNameKana.required'       => '保護者氏名（カナ）は必須です。',
            'email.required'                => 'メールアドレスは必須です。',
            'email.email'                   => '有効なメールアドレスを入力してください。',
            'email.unique'                  => 'このメールアドレスは既に登録されています。',
            'tel.required'                  => '電話番号は必須です。',
            'password.required'             => 'パスワードは必須です。',
            'password.confirmed'            => 'パスワード確認が一致しません。',
            
            // 子ども情報の配列要素
            'childName.*.required'          => '利用児氏名は必須です。',
            'childName.*.string'            => '利用児氏名は文字列で入力してください。',
            'childName.*.max'               => '利用児氏名は255文字以内で入力してください。',
            'childNameKana.*.required'      => '利用児氏名（カナ）は必須です。',
            'childNameKana.*.string'        => '利用児氏名（カナ）は文字列で入力してください。',
            'childNameKana.*.max'           => '利用児氏名（カナ）は255文字以内で入力してください。',
            'age.*.required'                => '利用児年齢は必須です。',
            'age.*.numeric'                 => '利用児年齢は数値で入力してください。',
            'gender.*.required'             => '性別は必須です。',
            'gender.*.in'                   => '性別は「男の子」または「女の子」で選択してください。',
            
            'postCode.required'             => '郵便番号は必須です。',
            'address.required'              => '住所は必須です。',
        ];
    }
}
