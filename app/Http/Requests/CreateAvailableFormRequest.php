<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateAvailableFormRequest extends FormRequest
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
            'datetime'  => ['required', 'date_format:Y-m-d H:i'],
        ];
    }

    public function messages()
    {
        return [
            'datetime.required'  => '利用可能日時をご入力ください',
            'datetime.date_format'      => 'yyyy/mm/dd hh:ii:ssの形式でご入力ください',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response['errors']  = $validator->errors()->toArray();
        throw new HttpResponseException(response()->json($response, 422));
    }
}
