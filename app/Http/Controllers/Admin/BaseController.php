<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin;
use App\Tools\Loader;
use Session;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{

    /* @var Admin $adminModel */
    protected $adminModel;
    protected $adminInfo;


    public function __construct()
    {
        $this->adminModel = Loader::singleton(Admin::class);

        if(config('admin.tokenType') == 'session') {
            $this->adminInfo = Session::get('admin');
        }elseif (config('admin.tokenType') == 'jwt') {
            //使用jwt
        }else {
            //其他方式不管
        }

    }

    /**
     * @return mixed
     * 获取当前管理员数据
     */
    public function getAdminInfo() {
        $admin = $this->adminModel->getOne($this->getAdminId());
        if(!$admin) {

        }

        return $admin;
    }

    /**
     * @return mixed
     * 获取管理员id
     */
    public function getAdminId() {
        return $this->adminInfo['id'];
    }


    /**
     * @param $adminId
     * 判断当前是否为自己管理员
     */
    public function isOwnAdminId($adminId) {
        if($adminId != $this->getAdminId()) {
            //抛出异常
        }
    }
}
