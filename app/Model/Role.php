<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 * @package App\Model
 * 角色控制器
 */
class Role extends Model
{
    protected $guarded = [];
    protected $table = 'role';
    protected $primaryKey = 'id';


    /**
     * @param $pageSize
     * @param $roleName
     * @return array
     * 获取角色列表
     */
    public function getList($pageSize,$roleName) {
        $list = Role::when(!empty($roleName),function($query) use ($roleName) {
            return $query->where('role_name','like','%'.$roleName.'%');
        })->orderBy('id','desc')->paginate($pageSize);

        $return = [];

        if(!empty($list)) {
            foreach ($list ?? [] as $role) {
                $return[] = [
                    'id'=>$role->id,
                    'roleName'=>$role->role_name,
                    'description'=>$role->description,
                    'createdAt'=>$role->created_at,
                    'updatedAt'=>$role->updated_at
                ];
            }
        }
        return [$list,$return];
    }

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


    /**
     * @param $id
     * @param $roleName
     * @return mixed
     * 获取角色名是否存在
     */
    public function getRoleNameIsExistsExceptId($id,$roleName) {
        return Role::where([
            ['id','<>',$id],
            ['role_name','=',$roleName]
        ])->count();
    }
}
