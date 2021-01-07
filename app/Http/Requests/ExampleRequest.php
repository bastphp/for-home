<?php

namespace App\Http\Requests;

use App\Rules\Example;

class ExampleRequest extends BaseRequest
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
            'name' => ['required', new Example(), 'max:10'],
            'sex'  => 'sometimes|required|integer'
        ];
    }

    /**
     * 获取已定义的验证规则的错误消息。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The :attribute field is required',
            'name.max'  => 'The :attribute field may not be greater than :max characters.',
        ];
    }
}
