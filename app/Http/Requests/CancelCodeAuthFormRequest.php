<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CancelCodeAuthFormRequest extends FormRequest
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
            'id'                => ['required',],
            'cancel_code'       => ['required',],
        ];
    }

    public function messages()
    {
        return [
            'id.required'              => 'idをご入力ください',
            'cancel_code.required'               => 'キャンセルコードをご入力ください',
        ];
    }
}
