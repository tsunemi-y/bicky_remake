<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationCalenderFormRequest extends FormRequest
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
            'ym'  => ['date_format:Y-m'],
        ];
    }

    public function messages()
    {
        return [
            'ym.date_format' => 'カレンダーの日時は、yyyy-mmの形式でご入力ください',
        ];
    }
}
