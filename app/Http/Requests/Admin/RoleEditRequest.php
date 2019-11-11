<?php

namespace App\Http\Requests\Admin;

/**
 * Class RoleEditRequest
 * @package App\Http\Requests\Admin
 * 角色编辑校验器
 */
class RoleEditRequest extends BaseRequest
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
            'roleName'=>'required',
            'description'=>'max:150'
        ];
    }

    public function messages()
    {
        return [
            'id.required'=>'id为空',
            'id.numeric'=>'id类型错误',
            'roleName.required'=>'请填写角色',
            'description.max'=>'描述字数不能大于150个字符'
        ];
    }
}
