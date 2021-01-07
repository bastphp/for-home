<?php

namespace App\Http\Requests;

use App\Rules\Example;

class RegisterRequest extends BaseRequest
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
            'name'   => 'required',
            'phone'  => 'required',
            'floor'  => 'required',
            'room'   => 'required',
            'code'   => 'required',
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
            'name.required'  => '名字必填',
            'phone.required' => '手机号必填',
            'floor.required' => '楼号必填',
            'room.required'  => '房号必填',
        ];
    }
}
