<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationFormRequest extends FormRequest
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
        if (!empty($this->request->all()['modal_btn']) && $this->request->all()['modal_btn'] == 'yes') {
            return [
                'name'              => ['required', 'string'],
                'age'               => ['required', 'integer'],
                'gender'            => ['required'],
                'email'             => ['required', 'email'],
                'diagnosis'         => ['required', 'string'],
                'address'           => ['required', 'string'],
                'Introduction'      => ['nullable', 'string'],
                'reservation_date'  => ['required', 'date'],
                'reservation_time'  => ['required',],
                'note'              => ['nullable',],
            ];
        } else {
            return [
                'name'              => ['required', 'string'],
                'email'             => ['required', 'email'],
                'reservation_date'  => ['required', 'date'],
                'reservation_time'  => ['required',],
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required'              => '氏名をご入力ください',
            'name.string'                => '文字でご入力ください',

            'age.required'               => '年齢をご入力ください',
            'age.integer'                => '数字でご入力ください',

            'gender.required'            => '性別をご入力ください',

            'email.required'             => 'emailをご入力ください',
            'email.email'                => 'メール形式でご入力ください',

            'diagnosis.required'         => '診断名をご入力ください',
            'diagnosis.string'           => '文字でご入力ください',

            'address.required'           => '住所をご入力ください',
            'address.string'             => '文字でご入力ください',

            'reservation_date.required'  => '予約日をご入力ください',
            'reservation_date.date'      => '日付形式でご入力ください',

            'reservation_time.required'  => '予約時間をご入力ください',
        ];
    }
}
