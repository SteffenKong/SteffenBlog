<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $guarded = [];
    protected $table = 'role';
    protected $primaryKey = 'id';


    /**
     * @param $id
     * @return array
     * 获取单个角色
     */
    public function getOne($id) {
        $role = Role::where('id',$id)->first();
        $return = [];
        if($role) {
            $return = [
                'id'=>$role->id,
                'roleName'=>$role->role_name,
                'description'=>$role->description,
                'createdAt'=>$role->created_at,
                'updatedAt'=>$role->updated_at
            ];
        }
        return $return;
    }


    /**
     * @param $roleName
     * @param string $description
     * @return mixed
     * 添加角色
     */
    public function add($roleName,$description = '') {
        return Role::create(
            [
                'role_name'=>$roleName,
                'description'=>$description,
                'created_at'=>Carbon::now()->toDateTime(),
                'updated_at'=>Carbon::now()->toDateTimeString()
            ]
        );
    }


    /**
     * @param $id
     * @param $roleName
     * @param $description
     * @return mixed
     * 更新角色
     */
    public function edit($id,$roleName,$description) {
        return Role::where('id',$id)->update([
            'role_name'=>$roleName,
            'description'=>$description,
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
    }


    /**
     * @param $id
     * @return int
     * 删除角色
     */
    public function deleteRole($id) {
        return Role::destroy($id);
    }
}
