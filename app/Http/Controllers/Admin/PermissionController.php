<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PermissionAddRequest;
use App\Http\Requests\Admin\PermissionEditRequest;
use App\Model\Permission;
use App\Tools\Loader;
use Illuminate\Http\Request;

/**
 * Class PermissionController
 * @package App\Http\Controllers\Admin
 * 权限控制器
 */
class PermissionController extends BaseController
{

    /* @var Permission $permissionModel */
    protected $permissionModel;

    public function __construct() {
        parent::__construct();
        $this->permissionModel = Loader::singleton(Permission::class);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 权限列表
     */
    public function index(Request $request) {
        $permissions = $this->permissionModel->getList();
        return view('/admin/permission/index',compact('permissions'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 添加权限模板
     */
    public function add() {
        //去除树状权限数据
        $perissions = $this->permissionModel->getList();
        return view('/admin/permission/add',compact('perissions'));
    }

    /**
     * @param PermissionAddRequest $request
     * @return \Illuminate\Http\JsonResponse
     * 权限添加
     */
    public function doAdd(PermissionAddRequest $request) {
        $data = $request->post();

        if($this->permissionModel->getIsExistsByFielName('permission_name',$data['permissionName'])) {
            return jsonPrint('001','权限名称已存在');
        }
        if(!empty($data['url']) && $this->permissionModel->getIsExistsByFielName('url',$data['url'])) {
            return jsonPrint('001','权限路由已存在');
        }

        if(!$this->permissionModel->add($data['permissionName'],$data['parentId'],$data['url'],$data['method'])) {
            return jsonPrint('001','权限录入失败!');
        }
        return jsonPrint('000','权限录入成功!');
    }


    /**
     * @param $id
     * 编辑模板
     */
    public function update($id) {
        $permission = $this->permissionModel->getOne($id);
        $allPermission = $this->permissionModel->getList();
        return view('/admin/permission/edit',compact('allPermission','permission'));
    }


    /**
     * @param PermissionEditRequest $request
     * @return \Illuminate\Http\JsonResponse
     * 权限编辑
     */
    public function edit(PermissionEditRequest $request) {
        $data = $request->post();
        if(!$this->permissionModel->getIsExistsByFieldNameExceptId($data['id'],'permissionName',$data['permissionName'])) {
            return jsonPrint('001','权限名称已存在');
        }
        if(!empty($data['url']) && !$this->permissionModel->getIsExistsByFieldNameExceptId($data['id'],'url',$data['url'])) {
            return jsonPrint('001','权限路由已存在');
        }
        if(!empty($data['method']) && !$this->permissionModel->getIsExistsByFieldNameExceptId($data['id'],'method',$data['method'])) {
            return jsonPrint('001','权限方法已存在');
        }
        if(!$this->permissionModel->edit($data['id'],$data['permissionName'],$data['parentId'],$data['url'],$data['method'])) {
            return jsonPrint('001','权限编辑成功!');
        }
        return jsonPrint('000','权限编辑成功!');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * 权限删除
     */
    public function delete($id) {
        if($this->permissionModel->deletePermission($id)) {
            return jsonPrint('001','权限删除失败');
        }
        return jsonPrint('000','权限删除成功!');
    }
}
