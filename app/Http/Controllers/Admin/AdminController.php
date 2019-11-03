<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\AdminAddRequest;
use App\Model\Admin;
use App\Tools\Loader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

    /* @var Admin $adminModel */
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = Loader::singleton(Admin::class);
    }

    public function index(Request $request) {

        return view('/admin/admin/index');
    }


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

        if(!$this->adminModel->add($data['account'],$data['password'],$data['status'],$data['isAdmin'],$data['email'],$data['phone'])) {
            return jsonPrint('001','录入失败');
        }

        return jsonPrint('000','录入成功');
    }


    public function update() {
        return view('/Admin/admin/edit');
    }

    public function edit(AdminEditRequest $request) {

    }

    public function delete(Request $request) {

    }

    public function deleteAll(Request $request) {

    }
}
