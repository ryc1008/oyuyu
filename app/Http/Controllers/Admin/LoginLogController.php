<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Login;
use Illuminate\Http\Request;

class LoginLogController extends Controller
{

    //配置项
    public function config(){
        try {
            $config =  [
                'status' => Login::STATUS_TEXT,
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
            $params = $request->all();
            $lists = Login::list($params, [ 'id', 'username', 'status', 'address', 'ip', 'login_at']);
            state_to_text($lists, [
                'status' => Login::STATUS_TEXT,
            ]);
            return $this->returnJson(0, $lists);
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
            Login::destroy($id);
            return $this->returnJson();
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

    //查询
    public function check(Request $request){
        try {
            $id = $request->post('id', 0);
            if (empty($id)) {
                return $this->returnJson(1, null, 'ID参数必须存在');
            }
            $info = Login::select(['password'])->find($id);
            if(!$info){
                return $this->returnJson(1, null, '查询数据不存在');
            }
            return $this->returnJson(0, $info);
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }


}
