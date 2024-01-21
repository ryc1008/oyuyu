<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Airdrop;
use App\Models\Category;
use App\Models\Demand;
use App\Models\User;
use Illuminate\Http\Request;

class AirdropController extends Controller
{

    public function index(){
        $time = time();
        return view('web.airdrop.index', compact('time'));
    }


    public function iframe(Request $request){
        try {
            $acc = $request->get('acc', '');
            $user = User::where('acc', $acc)->first();
            if(!$user){
                $this->register($acc);
            }
            $result = $this->client('torpedo_find', ['acc' => $acc]);
            if($result['status'] == 200){
                $setting = config('setting');
                $update = $this->getUserUpdateTorpedo($result['data']['items'], $setting);
                $user->update($update);
                $torpedo = $update;
                return view('web.airdrop.iframe', compact('acc', 'torpedo'));
            }
            return $this->returnJson(1, null, 'system error');
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }


    //空投鱼雷
    public function update(Request $request){
        try {
            $data = $request->all();
            if($data['number'] <= 0){
                return $this->returnJson(1, null, '请填写空投鱼雷数量');
            }
            $user = User::where('acc', $data['acc'])->first();
            if($user){
                $verify = $this->verify($data['type'], $data['number'], $user);
                if(!$verify){
                    return $this->returnJson(1, null, '抱歉，当前鱼雷数量不足');
                }
                //由于数据库和接口是一致性的，所以不需要单独查询，直接更新接口就行，不然空投了继续使用会出问题
                //更新自己鱼雷及接口
                $result = $this->updateTorpedo($data['acc'], $data['type'], $data['number'], 11);
                if($result['status'] == 200){
                    $setting = config('setting');
                    $update = $this->getUserUpdateTorpedo($result['data']['items'], $setting);
                    $user->update($update);
                    //创建记录
                    Airdrop::create([
                        'acc_publish' => $data['acc'],
                        'type' => $data['type'],
                        'number' => $data['number'],
                        'name' => Airdrop::TYPE_TEXT[$data['type']],
                        'redeem_code' => redeem_code(),
                        'status' => Airdrop::STATUS_1
                    ]);
                    return $this->returnJson(0, null, '空投成功，请稍后...');
                }
                return $this->returnJson(1, null, $result['msg']);
            }
            return $this->returnJson(1, null, '参数非法');
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

    //空投记录
    public function record(Request $request){
        try {
            $acc = $request->get('acc', '');
            $user = User::where('acc', $acc)->first();
            if($user){
                $list = Airdrop::where('acc_publish', $acc)->where('status', Airdrop::STATUS_1)->get();
                return $this->returnJson(0, $list);
            }
            return $this->returnJson(1, null, '参数非法');
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }

    }

    //兑换
    public function redeem(Request $request){
        try {
            $code = $request->post('code', '');
            $acc = $request->post('acc', '');
            $user = User::where('acc', $acc)->first();
            if($user){
                $gif = Airdrop::where('redeem_code', $code)->where('status', Airdrop::STATUS_1)->first();
                if(!$gif){
                    return $this->returnJson(1, null, '兑换码错误或者已失效');
                }
                //更新兑换者鱼雷及接口
                $result = $this->updateTorpedo($user['acc'], $gif['type'], $gif['number'], 1);
                if($result['status'] == 200){
                    //更新兑换者本地用户数据
                    $update = $this->getUserUpdateTorpedo($result['data']['items'], config('setting'));
                    $user->update($update);
                    //更新空投记录
                    $gif->update(['status' => Airdrop::STATUS_2,  'acc_accept' => $acc]);
                    return $this->returnJson(0, null, '操作成功');
                }
                return $this->returnJson(1, null, $result['msg']);
            }
            return $this->returnJson(1, null, '参数非法');
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }



    }

    //更新鱼雷接口
    protected function updateTorpedo($acc, $type, $number, $option){
        return $this->client('torpedo_update', [
            'acc' => $acc,
            'item_id' => $type, // 25白银 26黄金 27钻石
            'opType' => $option,//1增加 11减少
            'num' => $number,
        ], 'POST');
    }


























    public function test(){
        return view('web.airdrop.test');
    }

    public function demo(){
        return view('web.airdrop.demo');
    }

}
