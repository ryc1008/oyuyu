<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //列表
    public function list(Request $request)
    {
        try {
            $params = $request->all();
            $lists = Role::list($params, ['id','title','brief','created_at']);
            return $this->returnJson(0, $lists);
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

    //结构
    public function tree(){
        try {
            $lists = Role::tree();
            return $this->returnJson(0, $lists);
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

    //权限
    public function access(Request $request){
        try {
            $id = $request->get('id', 0);
            if (empty($id)) {
                return $this->returnJson(1, null, 'ID参数必须存在');
            }
            $info = Role::findOrFail($id);
            if (empty($info)) {
                return $this->returnJson(1, null, '您要操作的信息不存在');
            }
            return $this->returnJson(0,$info['rules']);
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

    //更新
    public function update(Request $request)
    {
        try {
            $data = $request->all();
            if (isset($data['id']) && $data['id']) {
                $info = Role::findOrFail($data['id']);
                $info->update($data);
                return $this->returnJson(0, null, '修改角色信息成功');
            } else {
                $data['rules'] = [];
                Role::create($data);
                return $this->returnJson(0, null, '新增角色信息成功');
            }
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

    //删除
    public function destroy(Request $request)
    {
        try {
            $id = $request->get('id');
            if (empty($id)) {
                return $this->returnJson(1, null, 'ID参数必须存在');
            }
            $id = is_array($id) ? $id : [$id];
            Role::destroy($id);
            return $this->returnJson();
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }
}
