<?php

namespace App\Http\Requests\Admin;

/**
 * Class RoleAddRequest
 * @package App\Http\Requests\Admin
 * 角色添加校验器
 */
class RoleAddRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'roleName'=>'required|unique:role',
            'description'=>'max:150'
        ];
    }

    public function messages()
    {
        return [
            'roleName.required'=>'请填写角色名称',
            'roleName.unique'=>'角色名称已存在',
            'description.max'=>'描述字数不能大于150个字符'
        ];
    }
}
