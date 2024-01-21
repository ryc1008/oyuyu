<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Airdrop;
use App\Models\Category;
use App\Models\Cost;
use App\Models\Demand;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use QL\QueryList;

class DiamondController extends Controller
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
                    return view('web.diamond.iframe', compact('user', 'torpedo', 'setting'));
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
                //更新钻石和鱼雷接口 opType//1增加 11减少
                $result = $this->client('diamond_recharge', [
                    'acc' => $data['acc'],
                    'opType' => 1,
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
                    $user->update($update);
                    //生成兑换记录
                    Cost::create([
                        'acc' => $data['acc'],
                        'uid' => $user['id'],
                        'type' => $data['type'],
                        'number' => $data['number'],
                        'redeem_number' => $data['gold'],
                        'group' => Cost::GROUP_2,
                    ]);
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
