<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\AdminException;
use App\Model\Admin;
use App\Model\Role;
use App\Tools\Loader;
use Session;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{

    /* @var Admin $adminModel */
    protected $adminModel;

    /* @var Role $roleModel */
    protected $roleModel;

    protected $adminSessionInfo;


    public function __construct()
    {
        $this->adminModel = Loader::singleton(Admin::class);
        $this->roleModel = Loader::singleton(Role::class);

        if(config('admin.tokenType') == 'session') {
            $this->adminSessionInfo = Session::get('admin');
        }elseif (config('admin.tokenType') == 'jwt') {
            //使用jwt
        }else {
            //其他方式不管
        }

    }

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
        return $this->adminSessionInfo['id'];
    }


    /**
     * @param $adminId
     * @throws AdminException
     * 判断当前是否为自己管理员
     */
    public function isOwnAdminId($adminId) {
        $bool = true;
        if(is_array($adminId)) {
            $bool = in_array($this->getAdminId(),$adminId);
        }else {
            if($adminId != $this->getAdminId()) {
                $bool = false;
            }
        }

        if(!$bool) {
            //抛出异常
            throw new AdminException('非法操作');
        }
    }
}
