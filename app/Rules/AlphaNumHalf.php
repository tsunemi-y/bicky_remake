<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AlphaNumHalf implements Rule
{
    /**
     * Determine if the validation rule passes.（バリデーションの成功を判定）
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match('/^[a-zA-Z0-9]+$/', $value); //追記
    }

    /**
     * Get the validation error message.（バリデーションエラーメッセージの取得）
     *
     * @return string
     */
    public function message()
    {
        return 'パスワードは半角英数字で入力してください'; //追記
    }
}
