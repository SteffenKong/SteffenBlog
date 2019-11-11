<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminAddRequest;
use App\Http\Requests\Admin\AdminEditRequest;
use App\Model\Admin;
use App\Tools\Loader;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\BaseController;

/**
 * Class AdminController
 * @package App\Http\Controllers\Admin
 * 管理员控制器
 */
class AdminController extends BaseController
{

    public function __construct() {
        parent::__construct();
    }


    /**
     * @param Request $request
     * @return mixed
     * 首页模板
     */
    public function index(Request $request) {
        $pageSize = 10;
        $account = $request->get('account','');
//        $email = $request->get('email','');
//        $phone = $request->get('phone','');
        $status = $request->get('status',-1);
        list($paginate,$data) = $this->adminModel->getList($pageSize,$account,$status);
        return view('/admin/admin/index',compact('paginate','data'));
    }


    /**
     * @return mixed
     * 添加模板
     */
    public function add() {
        return view('/admin/admin/add');
    }


    /**
     * @param AdminAddRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * 添加管理员
     */
    public function doAdd(AdminAddRequest $request) {
        $data = $request->post();
        if(!$this->adminModel->add($data['account'],$data['password'],$data['status'],$data['email'],$data['phone'])) {
            return jsonPrint('001','录入失败');
        }
        return jsonPrint('000','录入成功');
    }


    /**
     * @return mixed
     * 编辑模板
     */
    public function update($id) {
        //取出旧数据
        $admin = $this->adminModel->getOne($id);
        return view('/Admin/admin/edit',compact('admin'));
    }


    /**
     * @param AdminEditRequest $request
     * @return mixed
     * @throws \Exception
     * 编辑管理员
     */
    public function edit(AdminEditRequest $request) {
        $data = $request->post();

        //判断数据唯一
        if($this->adminModel->checkFieldIsExistsExceptIdByAdmin($data['id'],'account',$data['account'])) {
            return jsonPrint('002','帐号已存在');
        }

        if($this->adminModel->checkFielDIsExistsExceptIdByAdminInfo($data['id'],'email',$data['email'])) {
            return jsonPrint('002','邮箱已存在');
        }

        if($this->adminModel->checkFielDIsExistsExceptIdByAdminInfo($data['id'],'phone',$data['phone'])) {
            return jsonPrint('002','手机号码已存在');
        }


        if(!$this->adminModel->edit($data['id'],$data['account'],$data['password'],$data['status'],$data['email'],$data['phone'])) {
            return jsonPrint('001','编辑失败');
        }

        return jsonPrint('000','编辑成功');
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws \Throwable
     * 删除单个管理员
     */
    public function delete(Request $request) {
        $id = $request->get('id');
        if(empty($id)) {
            return redirect('/admin/admin/index');
        }

        if($this->isUnDeleteAdmin($id)) {
            return jsonPrint('001','不能删除的管理员!');
        }

        if(!$this->adminModel->deleteOne($id)) {
            return jsonPrint('001','删除失败');
        }

        return jsonPrint('000','删除成功');
    }


    /**
     * @param Request $request
     * @return mixed
     * @throws \Throwable
     * 批量删除
     */
    public function deleteAll(Request $request) {
        $ids = $request->get('ids',[]);
        if(empty($ids)) {
            return redirect('/admin/admin/index');
        }

        if(!$this->adminModel->deleteAll($ids)) {
            return jsonPrint('001','删除失败');
        }
        return jsonPrint('000','删除成功');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * 更改管理员状态
     */
    public function changeStatus(Request $request) {
        $adminId = $request->get('id');
        if(empty($adminId)) {
            return jsonPrint('001','非法访问!');
        }

        if($adminId  == $this->getAdminId()) {
            return jsonPrint('001','不能禁用当前管理员!');
        }

        if(!$this->adminModel->changeStatus($adminId)) {
            return jsonPrint('001','操作失败!');
        }

        return jsonPrint('000','操作成功!');
    }
}
