<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VipController extends Controller
{

    public function iframe(Request $request){
        try {
            $acc = $request->get('acc', '');
            $user = User::where('acc', $acc)->first();
            if($user){
                $result = $this->client('torpedo_find', ['acc' => $acc]);
                if($result['status'] == 200){
                    $setting = config('setting');
                    $update = $this->getUserUpdateTorpedo($result['data']['items'], $setting);
                    $user->update($update);
                    $torpedo = $update;
                    $level = $this->level($user['vip_exp']);
                    return view('web.vip.iframe', compact('user', 'torpedo', 'setting', 'level'));
                }
            }
            return $this->returnJson(1, null, 'system error');
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }


    //兑换
    public function update(Request $request){
        try {
            $data = $request->all();
            $user = User::where('acc', $data['acc'])->first();
            if($user){
                $verify = $this->verify($data['type'], $data['number'], $user);
                if(!$verify){
                    return $this->returnJson(1, null, '抱歉，当前鱼雷数量不足');
                }
                //更新VIP经验和鱼雷接口
                $result = $this->client('vip_recharge', [
                    'acc' => $data['acc'],
                    'diamondNum' => $data['gold'],
                ], 'POST');
                $result = $this->client('torpedo_update', [
                    'acc' => $data['acc'],
                    'opType' => 11,
                    'item_id' => $data['type'],
                    'num' => $data['number'],
                ], 'POST');
                if($result['status'] == 200){
                    $setting = config('setting');
                    $update = $this->getUserUpdateTorpedo($result['data']['items'], $setting);
                    //根据鱼雷类型换算成白银鱼雷
                    $torpedo = $this->scaler($data['type'], $data['number'], $setting);
                    $update['consume_total'] = DB::raw('`consume_total` + '. $torpedo);
                    $vipExp = $user['vip_exp'] + $data['gold'];
                    $update['vip_exp'] = $vipExp;
                    $update['vip'] = $this->level($vipExp);
                    $user->update($update);
                    //生成兑换记录
                    Cost::create([
                        'acc' => $data['acc'],
                        'uid' => $user['id'],
                        'type' => $data['type'],
                        'number' => $data['number'],
                        'redeem_number' => $data['gold'],
                        'group' => Cost::GROUP_3,
                    ]);
                    return $this->returnJson(0, $update['vip'], '兑换成功，请稍后...');
                }
                return $this->returnJson(1, null, $result['msg']);
            }
            return $this->returnJson(1, null, '参数非法');
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }


    protected function level($vipExp){
        $exps = [0, 10, 100, 200, 500, 1000, 2000, 5000, 10000, 20000, 50000];
        $records = array_filter($exps, function ($item) use($vipExp){
            return $item <= $vipExp;
        });
        return array_search(max($records), $records);
    }










}
