<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\LoginRequest;
use App\Model\Admin;
use Illuminate\Http\Request;
use App\Tools\Loader;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

/**
 * Class LoginController
 * @package App\Http\Controllers\admin
 */
class LoginController extends Controller
{

    /* @var Admin $adminModel */
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = Loader::singleton(Admin::class);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * 登录界面
     */
    public function login() {
        return view('/admin/login/login');
    }


    /**
     * @param LoginRequest $request
     * 登录动作
     */
    public function sign(LoginRequest $request) {
        $account = $request->get('account');
        $passowrd = $request->get('password');

        $res = $this->adminModel->login($account,$passowrd);

        $status = $this->adminModel->getStatus($res['id']);

        if(!$status) {
            return jsonPrint('001','管理员已被禁用!');
        }

        if(!$res) {
            return jsonPrint('001','登录失败');
        }

        //成功提示
        return jsonPrint('000','登录成功');
    }



    /**
     * 退出登录
     */
    public function logout() {
        Session::forget('admin');

        //跳转到login页面
        return redirect('/admin/login');
    }


    /**
     * @return \Illuminate\Http\JsonResponse
     * 获取公钥
     */
    public function getPublicKey() {
        return jsonPrint('000','获取成功',['publicKey'=>config('admin.publicKey')]);
    }
}
