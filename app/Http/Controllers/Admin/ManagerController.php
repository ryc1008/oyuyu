<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class ManagerController extends Controller
{
    //配置项
    public function config(){
        try {
            $config =  [
                'status' => Admin::STATUS_TEXT,
            ];
            return $this->returnJson(0, $config);
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

    //列表
    public function list(Request $request)
    {
        try {
            $param = $request->all();
            $lists = Admin::list($param);
            state_to_text($lists, [
                'status' => Admin::STATUS_TEXT,
            ]);
            return $this->returnJson(0, $lists);
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
                $info = Admin::findOrFail($data['id']);
                if ($data['password']) {
                    $data['password'] = bcrypt($data['password']);
                } else {
                    unset($data['password']);
                }
                $info->update($data);
                return $this->returnJson(0, null, '修改管理员信息成功');
            } else {
                $data['password'] = $data['password'] ? bcrypt($data['password']) : bcrypt('123456');
                Admin::create($data);
                return $this->returnJson(0, null, '新增管理员信息成功');
            }
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

    //锁定
    public function lock(Request $request)
    {
        try {
            $id = $request->get('id');
            if (empty($id)) {
                return $this->returnJson(1, null, 'ID参数必须存在');
            }
            $id = is_array($id) ? $id : [$id];
            Admin::whereIn('id', $id)->update(['status' => Admin::STATUS_2]);
            return $this->returnJson();
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

    //激活
    public function active(Request $request)
    {
        try {
            $id = $request->get('id');
            if (empty($id)) {
                return $this->returnJson(1, null, 'ID参数必须存在');
            }
            $id = is_array($id) ? $id : [$id];
            Admin::whereIn('id', $id)->update(['status' => Admin::STATUS_1]);
            return $this->returnJson();
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
            Admin::destroy($id);
            return $this->returnJson();
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

    //管理员信息
    public function user(){
        try {
            $user = auth('admin')->user();
            $access = $user->role()->value('rules');
            return $this->returnJson(0,['user' => $user, 'rules' => $access]);
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }
}
