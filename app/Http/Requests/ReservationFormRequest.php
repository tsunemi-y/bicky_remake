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

        return [
            'avaDate'  => ['required', 'date'],
            'avaTime'  => ['required',],
        ];
    }

    public function messages()
    {
        return [
            'avaDate.required'  => '予約日をご入力ください',
            'avaDate.date'      => '日付形式でご入力ください',

            'avaTime.required'  => '予約時間をご入力ください',
        ];
    }
}
