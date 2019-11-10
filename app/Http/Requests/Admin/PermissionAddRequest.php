<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PermissionAddRequest
 * @package App\Http\Requests\Admin
 * 添加权限校验器
 */
class PermissionAddRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.

     * @return array
     */
    public function rules()
    {
        return [
            'permissionName'=>'required|unique:permission,permission_name',
            'parentId'=>'numeric',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'permissionName.required'=>'请填写权限名',
            'permissionName.unique'=>'权限名已存在',
            'parentId.numeric'=>'父级权限id类型异常'
        ];
    }
}
