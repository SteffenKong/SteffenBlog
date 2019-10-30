<?php

namespace App\Model;

use Carbon\Carbon;
use App\Tools\Rsa;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Admin
 * @package App\Model
 * 管理员模型器
 */
class Admin extends Model
{

    protected $guarded = [];
    protected $primaryKey = 'id';
    protected $table = 'admin';


    /**
     * @param $account
     * @param $password
     * @return array|bool
     * 登录
     */
    public function login($account,$password) {
        $rsa = new Rsa();
        //导入私钥
        $rsa->setPrivateKey(config('admin.privateKey'));
        //私钥解密
        $pass = $rsa->decrpytByPrivateKey($password);
        $pass = bcrypt($pass);

        $admin = Admin::where('account',$account)->where('password',$pass)->first();

        if(!$admin) {
            return false;
        }

        return [
            'id'=>$admin->id,
            'account'=>$admin->account,
            'isAdmin'=>$admin->is_admin,
            'status'=>$admin->status
        ];
    }


    public function getList($pageSize,$account,$tel,$email,$status) {
//        Admin::when(!empty($account),function($query) {
//
//        })
//            ->when(!empty($tel))
    }


    /**
     * @param $account
     * @param $password
     * @param $tel
     * @param $email
     * @param $status
     * @return mixed
     * 添加管理员
     */
    public function add($account,$password,$tel,$email,$status) {

        //这里密码需要进行加密解密

        return Admin::create([
            'account'=>$account,
            'password'=>$password,
            'tel'=>$tel,
            'email'=>$email,
            'status'=>$status,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
    }

    /**
     * @param $id
     * @param $account
     * @param $password
     * @param $tel
     * @param $email
     * @param $status
     * @return mixed
     * 编辑管理员
     */
    public function edit($id,$account,$password,$tel,$email,$status) {

        //这里密码需要进行加密解密

        return Admin::where('id',$id)->update([
            'account'=>$account,
            'password'=>$password,
            'tel'=>$tel,
            'email'=>$email,
            'status'=>$status,
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
    }


    /**
     * @param $id
     * @return mixed
     * 更改管理员状态
     */
    public function changeStatus($id) {
        $newStatus = 1;
        $oldStatus = Admin::where('id',$id)->value('status');
        if($oldStatus == 1) {
            $newStatus = 0;
        }
        return Admin::where('id',$id)->update(['updated_at'=>Carbon::now()->toDateTimeString(),'status'=>$newStatus]);
    }


    /**
     * @param $id
     * @return mixed
     * 删除|批量删除管理员数据
     */
    public function delData($id) {
        if(is_array($id)) {
            //这里是批量删除数据的逻辑
            return Admin::whereIn('id',$id)->delete();
        }

        return Admin::where('id',$id)->delete();
    }


    /**
     * @param $id
     * @return mixed
     * 获取状态
     */
    public function getStatus($id) {
        return Admin::where('id',$id)->value('status');
    }
}
