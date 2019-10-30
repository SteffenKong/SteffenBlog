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

        if(!$res) {

        }

        //成功提示
    }



    /**
     * 退出登录
     */
    public function logout() {
        Session::forget('admin');

        //跳转到login页面
        return redirect('/admin/login');
    }
}
