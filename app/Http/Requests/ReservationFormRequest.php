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
                'name'              => ['required',],
                'age'               => ['required',],
                'gender'            => ['required',],
                'email'             => ['required',],
                'diagnosis'         => ['required',],
                'address'           => ['required',],
                'Introduction'      => ['nullable',],
                'reservation_date'  => ['required',],
                'reservation_time'  => ['required',],
                'note'              => ['nullable',],
            ];
        } else {
            return [
                'name'              => ['required',],
                'email'             => ['required',],
            ];
        }
    }

    public function messages()
    {
        if (!empty($this->request->all()['modal_btn']) && $this->request->all()['modal_btn'] == 'yes') {
            return [
                'name.required'              => '氏名をご入力ください',
                'age.required'               => '年齢をご入力ください',
                'gender.required'            => '性別をご入力ください',
                'email.required'             => 'emailをご入力ください',
                'diagnosis.required'         => '診断名をご入力ください',
                'address.required'           => '住所をご入力ください',
                'reservation_date.required'  => '予約日をご入力ください',
                'reservation_time.required'  => '予約時間をご入力ください',
            ];
        } else {
            return [
                'name.required'              => '氏名をご入力ください',
                'email.required'             => 'emailをご入力ください',
            ];
        }
    }
}
