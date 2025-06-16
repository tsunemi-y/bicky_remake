<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFormRequest extends FormRequest
{
    /**
     * ユーザーがこのリクエストを実行できるかどうかを判定
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * バリデーションルールを定義
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // 子ども情報はchildren配列で受け取る前提に修正
        $rules = [
            'parentName'        => 'required|string|max:255',
            'parentNameKana'    => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users,email',
            'tel'               => 'required|string|max:20',
            'password'          => 'required|string|min:8|confirmed',
            'postCode'          => 'required|string|max:8',
            'address'           => 'required|string|max:255',
            'introduction'      => 'nullable|string|max:255',
            
            // 子ども情報（children配列）
            'children'                  => 'required|array|min:1',
            'children.*.childName'      => 'required|string|max:255',
            'children.*.childNameKana'  => 'required|string|max:255',
            'children.*.childBirthDate' => 'required|date',
            'children.*.gender'         => 'required|string|in:男の子,女の子',
            'children.*.diagnosis'      => 'nullable|string|max:255',
        ];

        return $rules;
    }

    /**
     * バリデーションメッセージをカスタマイズ
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
            'postCode.required'             => '郵便番号は必須です。',
            'address.required'              => '住所は必須です。',
            // 子ども情報
            'children.required'                     => '利用児情報は1人以上入力してください。',
            'children.array'                        => '利用児情報の形式が正しくありません。',
            'children.*.childName.required'         => '利用児氏名は必須です。',
            'children.*.childName.string'           => '利用児氏名は文字列で入力してください。',
            'children.*.childName.max'              => '利用児氏名は255文字以内で入力してください。',
            'children.*.childNameKana.required'     => '利用児氏名（カナ）は必須です。',
            'children.*.childNameKana.string'       => '利用児氏名（カナ）は文字列で入力してください。',
            'children.*.childNameKana.max'          => '利用児氏名（カナ）は255文字以内で入力してください。',
            'children.*.childBirthDate.required'    => '利用児の生年月日は必須です。',
            'children.*.childBirthDate.date'        => '利用児の生年月日は日付形式で入力してください。',
            'children.*.gender.required'            => '性別は必須です。',
            'children.*.gender.in'                  => '性別は「男の子」または「女の子」で選択してください。',
            'children.*.diagnosis.string'           => '診断名は文字列で入力してください。',
            'children.*.diagnosis.max'              => '診断名は255文字以内で入力してください。',
        ];
    }
}
