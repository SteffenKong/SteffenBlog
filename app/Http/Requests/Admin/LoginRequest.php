<?php

namespace App\Http\Requests\Admin;

/**
 * Class LoginRequest
 * @package App\Http\Requests\Admin
 */
class LoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * 验证规则
     */
    public function rules()
    {
        return [
            'account'=>'required',
            'password'=>'required',
            'captcha'=>'required|captcha'
        ];
    }

    /**
     * @return array
     * 验证错误消息
     */
    public function messages()
    {
        return [
            'account.required'=>'帐号不能为空',
            'password.required'=>'密码不能为空',
            'captcha.required'=>'验证码不能为空',
            'captcha.captcha'=>'验证码错误'
        ];
    }
}
