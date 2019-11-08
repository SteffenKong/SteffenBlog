<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\RoleAddRequest;
use App\Http\Requests\Admin\RoleEditRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;

/**
 * Class RoleController
 * @package App\Http\Controllers\Admin
 * 角色控制器
 */
class RoleController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(Request $request) {

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 角色添加模板
     */
    public function add() {
        return view('/admin/role/add');
    }

    /**
     * @param RoleAddRequest $request
     * @return \Illuminate\Http\JsonResponse
     * 添加角色动作
     */
    public function doAdd(RoleAddRequest $request) {
        $data = $request->post();
        if(!$this->roleModel->add($data)) {
            return jsonPrint('001','角色录入失败');
        }
        return jsonPrint('000','角色录入成功');
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 编辑角色模板
     */
    public function edit($id) {
        //查询出旧数据
        $role = $this->roleModel->getOne($id);
        return view('/admin/role/edit',compact('role'));
    }

    /**
     * @param RoleEditRequest $request
     * @return \Illuminate\Http\JsonResponse
     * 编辑角色
     */
    public function doEdit(RoleEditRequest $request) {
        $data = $request->post();
        if(!$this->roleModel->edit($data['id'],$data['roleName'],$data['description'])) {
            return jsonPrint('001','角色编辑失败!');
        }

        return jsonPrint('000','角色编辑成功!');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * 删除角色
     */
    public function delete($id) {
        if(!$this->roleModel->deleteRole($id)) {
            return jsonPrint('001','角色删除失败!');
        }
        return jsonPrint('000','角色删除成功!');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 批量删除角色
     */
    public function deleteAll(Request $request) {
        $ids = $request->get('ids');
        if(!$this->roleModel->deleteRole($ids)) {
            return jsonPrint('001','角色删除失败!');
        }
        return jsonPrint('000','角色删除成功!');
    }
}
