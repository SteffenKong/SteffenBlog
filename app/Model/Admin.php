<?php

namespace App\Model;

use Carbon\Carbon;
use App\Tools\Rsa;
use Hash;
use DB;
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
     * @var
     */
    protected $rsa;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->rsa = new Rsa();
    }

    /**
     * @param $account
     * @param $password
     * @return array|bool
     * 登录
     */
    public function login($account,$password) {
        //导入私钥
        $this->rsa->setPrivateKey(config('admin.privateKey'));
        //私钥解密
        $pass = $this->rsa->decrpytByPrivateKey($password);

        $admin = Admin::where('account',$account)->first();

        //用户不存在
        if(!$admin) {
            return false;
        }

        //密码校验失败
        if(!Hash::check($pass,$admin->password)) {
            return false;
        }

        //重新给密码加密
        if (Hash::needsRehash($password)) {
            $hashed = Hash::make($pass);
            Admin::where('account',$account)->update(['password'=>$hashed]);
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
     * @param $status
     * @param $isAdmin
     * @param $tel
     * @param $email
     * @param $phone
     * @param $bigImage
     * @param $smallImage
     * @return bool
     * @throws \Exception
     * 添加管理员
     */
    public function add($account,$password,$status,$isAdmin,$email,$phone) {

        /********这里密码需要进行加密解密********/

        //导入私钥
        $this->rsa->setPrivateKey(config('admin.privateKey'));
        //私钥解密
        $pass = $this->rsa->decrpytByPrivateKey($password);
        $result = false;

        try{
            DB::beginTransaction();
            $result1 = Admin::create([
                'account'=>$account,
                'password'=>$pass,
                'status'=>$status,
                'is_admin'=>$isAdmin,
                'created_at'=>Carbon::now()->toDateTimeString(),
                'updated_at'=>Carbon::now()->toDateTimeString()
            ]);

            $result2 = AdminInfo::create([
                'user_id'=>$result1->id,
                'email'=>$email,
                'phone'=>$phone,
                'last_login_ip'=>'',
                'last_login_time'=>Carbon::now()->toDateTimeString(),
                'created_at'=>Carbon::now()->toDateTimeString(),
                'updated_at'=>Carbon::now()->toDateTimeString()
            ]);

            if($result1 && $result2) {
                $result = true;
            }
        }catch (\Exception $e) {
            $result = false;
        }

        if(!$result) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }


    /**
     * @param $id
     * @param $account
     * @param $password
     * @param $status
     * @param $isAdmin
     * @param $email
     * @param $phones
     * @return bool
     * @throws \Exception
     * 编辑管理员
     */
    public function edit($id,$account,$password,$status,$isAdmin,$email,$phone) {

        /********这里密码需要进行加密解密********/
        //导入私钥
        $this->rsa->setPrivateKey(config('admin.privateKey'));
        //私钥解密
        $pass = $this->rsa->decrpytByPrivateKey($password);
        $result = false;


        try{
            DB::beginTransaction();
            $result1 = Admin::where('id',$id)->update([
                'account'=>$account,
                'password'=>$pass,
                'status'=>$status,
                'is_admin'=>$isAdmin,
                'created_at'=>Carbon::now()->toDateTimeString(),
                'updated_at'=>Carbon::now()->toDateTimeString()
            ]);

            $result2 = AdminInfo::where('user_id',$id)->update([
                'user_id'=>$result1->id,
                'email'=>$email,
                'phone'=>$phone,
                'last_login_ip'=>'',
                'last_login_time'=>Carbon::now()->toDateTimeString(),
                'created_at'=>Carbon::now()->toDateTimeString(),
                'updated_at'=>Carbon::now()->toDateTimeString()
            ]);

            if($result1 && $result2) {
                $result = true;
            }
        }catch (\Exception $e) {
            $result = false;
        }

        if(!$result) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
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
     * @return bool
     * @throws \Throwable
     * 删除单个管理员数据
     */
    public function deleteOne($id) {
        $result = false;
        DB::transaction();
        try{
            $result1 = Admin::where('id',$id)->delete();
            $result2 = AdminInfo::where('user_id',$id)->delete();
        }catch (\Exception $e) {
            $result = false;
        }

        if(!$result) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }


    /**
     * @param $ids
     * @return bool
     * @throws \Throwable
     * 批量删除多个管理员数据
     */
    public function deleteAll(array $ids) {
        $result = false;
        DB::transaction();
        try{
            $result1 = Admin::whereIn('id',$ids)->delete();
            $result2 = AdminInfo::whereIn('user_id',$ids)->delete();
        }catch (\Exception $e) {
            $result = false;
        }

        if(!$result) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }


    /**
     * @param $id
     * @return mixed
     *获取管理员状态
     */
    public function getStatus($id) {
        return Admin::where('id',$id)->value('status');
    }



    /**
     * @param $id
     * @return array|bool
     * 获取单个管理员信息
     */
    public function getOne($id) {
        $admin = Admin::where('id',$id)->first();
        $adminInfo = AdminInfo::where('user_id',$id)->first();

        if(!$admin || !$adminInfo) {
            return false;
        }

        return [
            'id'=>$admin->id,
            'account'=>$admin->account,
            'status'=>$admin->status,
            'isAdmin'=>$admin->is_admin,
            'email'=>$adminInfo->email,
            'phone'=>$adminInfo->phone,
            'lastLoginIp'=>$adminInfo->last_login_ip,
            'lastLoginTime'=>$adminInfo->last_login_time,
            'createdAt'=>$admin->created_at,
            'updatedAt'=>$admin->updated_at
        ];
    }


    /**
     * @param $id
     * @param $fieldName
     * @param $val
     * @return mixed
     * 查询管理员表中某个数据是否存在，去除和本身数据比较
     */
    public function checkFieldIsExistsExceptIdByAdmin($id,$fieldName,$val) {
        return Admin::where('id','<>',$id)->where($fieldName,$val)->count();
    }


    /**
     * @param $userId
     * @param $fieldName
     * @param $val
     * @return mixed
     * 查询管理员附属表某个数据是否存在，去除和本身数据比较
     */
    public function checkFielDIsExistsExceptIdByAdminInfo($userId,$fieldName,$val) {
        return AdminInfo::where('user_id','<>',$userId)->where($fieldName,$val)->count();
    }
}
