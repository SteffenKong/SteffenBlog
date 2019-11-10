<?php

namespace App\Http\Requests\Admin;

/**
 * Class PermissionEditRequest
 * @package App\Http\Requests\Admin
 * 权限编辑
 */
class PermissionEditRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'permissionName'=>'required',
            'parentId'=>'numeric',
        ];
    }

    public function messages()
    {
        return [
            'permissionName.required'=>'请填写权限名',
            'parentId.numeric'=>'父级权限id类型异常'
        ];
    }
}
