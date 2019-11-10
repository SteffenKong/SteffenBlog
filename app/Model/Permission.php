<?php
namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * @package App\Model
 * 权限模型
 */
class Permission extends Model
{
    protected $guarded = [];
    protected $table = 'permission';
    protected $primaryKey = 'id';


    /**
     * 获取权限树状列表
     */
    public function getList() {
        $data = Permission::all();
        $newTree = [];
        if(!empty($data)) {
            foreach ($data ?? [] as $permission) {
                $newTree[] = [
                    'id'=>$permission->id,
                    'permissionName'=>$permission->permission_name,
                    'url'=>$permission->url,
                    'method'=>$permission->method,
                    'parentId'=>$permission->parent_id,
                    'createdAt'=>$permission->created_at,
                    'updatedAt'=>$permission->updated_at
                ];
            }
        }
        $tree = getTree($newTree);
        return array_reverse($tree);
    }


    /**
     * @param $permissionName
     * @param $parentId
     * @param $url
     * @param $method
     * @return mixed
     * 添加权限
     */
    public function add($permissionName,$parentId,$url,$method) {
        return Permission::create([
            'permission_name'=>$permissionName,
            'parent_id'=>$parentId,
            'url'=>$url,
            'method'=>$method,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
    }


    /**
     * @param $id
     * @param $permissionName
     * @param $parentId
     * @param $url
     * @param $method
     * @return mixed
     * 编辑权限
     */
    public function edit($id,$permissionName,$parentId,$url,$method) {
        return Permission::where('id',$id)->update([
            'permission_name'=>$permissionName,
            'parent_id'=>$parentId,
            'url'=>$url,
            'method'=>$method,
            'created_at'=>Carbon::now()->toDateTimeString(),
            'updated_at'=>Carbon::now()->toDateTimeString()
        ]);
    }


    /**
     * @param $id
     * @return int
     * 删除权限
     */
    public function deletePermission($id) {
        return Permission::destroy($id);
    }


    /**
     * @param $permissionId
     * @return array
     * 获取单个权限数据
     */
    public function getOne($permissionId) {
        $return = [];
        $permission = Permission::where('id',$permissionId)->first();
        if(!empty($permission)) {
            $return = [
                'id'=>$permission->id,
                'permissionName'=>$permission->permission_name,
                'parentId'=>$permission->parent_id,
                'url'=>$permission->url,
                'method'=>$permission->method,
                'createdAt'=>$permission->created_at,
                'updatedAt'=>$permission->updated_at
            ];
        }
        return $return;
    }


    /**
     * @param $id
     * @param $fieldName
     * @param $value
     * @return mixed
     * 编辑时获取已存在的字段数据,除了自身
     */
    public function getIsExistsByFieldNameExceptId($id,$fieldName,$value) {
        return Permission::where($fieldName,$value)->where('id','<>',$id)->count();
    }


    /**
     * @param $fieldName
     * @param $value
     * @return mixed
     * 查询某个值是否存在
     */
    public function getIsExistsByFielName($fieldName,$value) {
        return Permission::where($fieldName,$value)->count();
    }
}
