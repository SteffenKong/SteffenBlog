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
     * @param $tel
     * @param $email
     * @param $status
     * @return mixed
     * 编辑管理员
     */
    public function edit($id,$account,$password,$tel,$email,$status) {

        /********这里密码需要进行加密解密********/
        //导入私钥
        $this->rsa->setPrivateKey(config('admin.privateKey'));
        //私钥解密
        $pass = $this->rsa->decrpytByPrivateKey($password);
        $result = false;



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
