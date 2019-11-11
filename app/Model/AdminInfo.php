<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AdminInfo extends Model
{
    protected $guarded = [];
    protected $table = 'admin_info';
    protected $primaryKey = 'id';


    /**
     * @param $userId
     * @param $ip
     * @param $loginTime
     * @return mixed
     * 更新管理员登录信息
     */
    public function updateLoginInfo($userId,$ip,$loginTime) {
        return AdminInfo::updateOrCreate([
            'user_id'=>$userId
        ],[
            'last_login_ip'=>$ip,
            'last_login_time'=>$loginTime,
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
    }
}
