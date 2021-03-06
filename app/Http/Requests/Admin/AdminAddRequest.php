<?php

namespace App\Http\Requests\Admin;

class AdminAddRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'account'=>'required|unique:admin',
            'password'=>'required',
            'phone'=>'required|numeric|unique:admin_info',
            'isAdmin'=>'in:0,1',
            'status'=>'in:0,1',
            'email'=>'required|email|unique:admin_info'
        ];
    }

    /**
     * @return array
     * 返回错误信息
     */
    public function messages()
    {
        return [
            'account.required'=>'请填写帐号',
            'account.unique'=>'帐号已存在',
            'password.required'=>'请填写密码',
            'phone.required'=>'请填写手机号码',
            'phone.numeric'=>'手机号码格式必须为数字',
            'phone.unique'=>'手机号码已存在',
            'isAdmin.in'=>'是否为管理员类型异常',
            'status.in'=>'状态值类型异常',
            'email.required'=>'请填写邮箱',
            'email.email'=>'邮箱格式不正确',
            'email.unique'=>'邮箱已存在'
        ];
    }
}
