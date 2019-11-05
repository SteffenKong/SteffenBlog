<?php

namespace App\Http\Requests\Admin;

class AdminEditRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'=>'required|numeric',
            'account'=>'required',
            'password'=>'required',
            'phone'=>'required|numeric',
            'isAdmin'=>'in:0,1',
            'status'=>'in:0,1',
            'email'=>'required|email'
        ];
    }


    /**
     * @return array
     * 返回错误信息
     */
    public function messages()
    {
        return [
            'id.required'=>'管理员id为空',
            'id.numeric'=>'管理员id类型异常',
            'account.required'=>'请填写帐号',
            'password.required'=>'请填写密码',
            'phone.required'=>'请填写手机号码',
            'phone.numeric'=>'手机号码格式必须为数字',
            'isAdmin.in'=>'是否为管理员类型异常',
            'status.in'=>'状态值类型异常',
            'email.required'=>'请填写邮箱',
            'email.email'=>'邮箱格式不正确'
        ];
    }
}
