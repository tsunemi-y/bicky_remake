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
            'name'         => ['required',],
            'age'          => ['required',],
            'gender'       => ['required',],
            'email'        => ['required',],
            'diagnosis'    => ['required',],
            'address'      => ['required',],
            'Introduction' => ['required',],
            'date'         => ['required',],
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => '氏名をご入力ください',
            'age.required'          => '年齢をご入力ください',
            'gender.required'       => '性別をご入力ください',
            'email.required'        => 'emailをご入力ください',
            'diagnosis.required'    => '診断名をご入力ください',
            'address.required'      => '住所をご入力ください',
            'Introduction.required' => '紹介先をご入力ください',
            'date.required'         => '予約日をご入力ください',
        ];
    }
}
