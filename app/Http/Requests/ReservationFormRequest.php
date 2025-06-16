<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationFormRequest extends FormRequest
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
     * バリデーションルール
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date'     => ['required', 'date'],
            'time'     => ['required', 'date_format:H:i:s'],
            'children' => ['required', 'array', 'min:1'],
            'children.*' => ['integer', 'exists:children,id'],
            'course'   => ['required', 'integer', 'exists:courses,id'],
            'fee'      => ['required', 'integer', 'min:0'],
            'useTime'  => ['required', 'integer', 'min:0'],
        ];
    }

    /**
     * バリデーションメッセージ
     *
     * @return array
     */
    public function messages()
    {
        return [
            'date.required'        => '予約日をご入力ください',
            'date.date'            => '日付形式でご入力ください',
            'time.required'        => '予約時間をご入力ください',
            'time.date_format'     => '時間は「HH:MM:SS」形式でご入力ください',
            'children.required'    => '利用児を1人以上選択してください',
            'children.array'       => '利用児の形式が正しくありません',
            'children.min'         => '利用児を1人以上選択してください',
            'children.*.integer'   => '利用児IDが正しくありません',
            'children.*.exists'    => '選択された利用児が存在しません',
            'course.required'      => 'コースを選択してください',
            'course.integer'       => 'コースIDが正しくありません',
            'course.exists'        => '選択されたコースが存在しません',
            'fee.required'         => '料金が正しく計算されていません',
            'fee.integer'          => '料金が正しくありません',
            'fee.min'              => '料金は0円以上で入力してください',
            'useTime.required'     => '利用時間が正しく計算されていません',
            'useTime.integer'      => '利用時間が正しくありません',
            'useTime.min'          => '利用時間は0分以上で入力してください',
        ];
    }
}
