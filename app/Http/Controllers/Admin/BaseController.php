<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\AdminException;
use App\Model\Admin;
use App\Model\Role;
use App\Tools\Loader;
use Session;
use App\Http\Controllers\Controller;

/**
 * Class BaseController
 * @package App\Http\Controllers\Admin
 * 基类控制器
 */
class BaseController extends Controller
{
    /* @var Admin $adminModel */
    protected $adminModel;

    /* @var Role $roleModel */
    protected $roleModel;

    protected $adminSessionInfo;

    public function __construct() {
        $this->adminModel = Loader::singleton(Admin::class);
        $this->roleModel = Loader::singleton(Role::class);
    }


    /**
     * @return mixed|void
     */
    public function getTokenTypeVal() {
        if(config('admin.tokenType') == 'session') {
            return $this->getSession();
        }elseif (config('admin.tokenType') == 'jwt') {
            return $this->getJwt();
        }else {
            //其他方式不管
        }
    }


    /**
     * @return mixed
     */
    public function getSession() {
         return $this->adminSessionInfo = Session::get('admin');
    }


    public function getJwt() {}

    /**
     * @return mixed
     * @throws AdminException
     * 获取当前管理员数据
     */
    public function getAdminInfo() {
        $admin = $this->adminModel->getOne($this->getAdminId());
        if(!$admin) {
            throw new AdminException('管理员不存在');
        }

        return $admin;
    }


    /**
     * @return mixed
     * 获取管理员id
     */
    public function getAdminId() {
        return $this->getTokenTypeVal()['id'];
    }


    /**
     * @param $adminId
     * @throws AdminException
     * 判断当前是否为自己管理员
     */
//    public function isOwnAdminId($adminId) {
//        $bool = true;
//        if(is_array($adminId)) {
//            $bool = in_array($this->getAdminId(),$adminId);
//        }else {
//            if($adminId != $this->getAdminId()) {
//                $bool = false;
//            }
//        }
//
//        if(!$bool) {
//            //抛出异常
//            throw new AdminException('非法操作');
//        }
//    }


    /**
     * @param $adminId
     * @return bool
     * 判断是否为不可删除的管理员
     */
    public function isUnDeleteAdmin($adminId) {
        if($adminId == $this->getAdminId()) {
            return true;
        }
        if($adminId == 1) {
            return true;
        }
        return false;
    }
}
