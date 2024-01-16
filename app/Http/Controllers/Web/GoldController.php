<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Airdrop;
use App\Models\Category;
use App\Models\Cost;
use App\Models\Demand;
use App\Models\Jackpot;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use QL\QueryList;

class GoldController extends Controller
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
                    return view('web.gold.iframe', compact('user', 'torpedo', 'setting'));
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
                //更新金币和鱼雷接口 opType//1增加 11减少
                $result = $this->client('gold_recharge', [
                    'acc' => $data['acc'],
                    'opType' => 1,
                    'goldNum' => $data['gold'],
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
                    $update['convert_total'] = $user['convert_total'] + $torpedo; //总的兑换量
                    //增加兑换buff逻辑
                    $buff = $this->buffNum($user, $torpedo);
                    //更新用户buff值和总的buff值，总的兑换量
                    $update['buff_num'] = $user['buff_num'] + $buff; //buff值
                    $update['buff_total'] = $user['buff_total'] + $buff; //总的buff值
                    $user->update($update);
                    //生成兑换记录
                    Cost::create([
                        'acc' => $data['acc'],
                        'uid' => $user['id'],
                        'type' => $data['type'],
                        'number' => $data['number'],
                        'redeem_number' => $data['gold'],
                        'group' => Cost::GROUP_1,
                    ]);
                    //记录奖池
                    $userJackpot = Jackpot::where('acc', $data['acc'])->first();
                    $endBuffVal = $torpedo - $buff;
                    if($userJackpot){
                        $userJackpot->increment('buff', $endBuffVal);
                    }else{
                        Jackpot::create([
                            'acc' => $data['acc'],
                            'buff' => $endBuffVal,
                        ]);
                    }
                    return $this->returnJson(0, $result, '兑换成功，请稍后...');
                }
                return $this->returnJson(1, null, $result['msg']);
            }
            return $this->returnJson(1, null, '参数非法');
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }

    }








}
