<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $key = 'YOUXIPT';
    protected $target = [
        'torpedo_find' => 'http://111.230.11.24:1005/api/Torpedo/TorpedoByUid?',
        'torpedo_update' => 'http://111.230.11.24:1005/api/Torpedo/UpdateTorpedoByUid',
        'ticket_find' => 'http://111.230.11.24:1005/api/Ticket/GetTicketByUid?',
        'ticket_recharge' => 'http://111.230.11.24:1005/api/Ticket/UpdateTicket',
        'gold_recharge' => 'http://111.230.11.24:1005/api/GoldReCharge/UpdateGold',
        'diamond_recharge' => 'http://111.230.11.24:1005/api/DiamondReCharge/UpdateDiamond',
        'vip_recharge' => 'http://111.230.11.24:1005/api/VipExpertiseReCharge/UpdateExpertise',
    ];

    protected function returnJson($status = 0, $data = null, $message = null){
        $data = [
            "status" => $status,
            "data" => $data,
            "message" => $message ?? '操作成功'
        ];
        return response()->json($data);
    }

    protected function buyuJson($status = 0, $data = null, $message = null){
        $data = [
            "status" => $status,
            "data" => $data,
            "msg" => $message ?? 0
        ];
        return response()->json($data);
    }


    protected function client($name = '', $data = [], $method = 'GET'){
        $client = new Client();
        $timespan = time();
        $sign = md5($data['acc'] . $this->key . $timespan);
        $link = $this->target[$name];
        $data['timespan'] = $timespan;
        $data['sign'] = $sign;
        if($method == 'GET'){
            $link .= http_build_query($data);
            $result = $client->get($link)->getBody()->getContents();
        }else{
            $result = $client->post($link,  [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'body' => json_encode($data)
            ])->getBody()->getContents();
        }
        $result = json_decode($result, true);
        return $result;
    }

    protected function getUserUpdateTorpedo($data, $setting){
        $return = [
            'torpedo_silver' => 0,
            'torpedo_gold' => 0,
            'torpedo_diamond' => 0,
            'silver_number' => 0,
        ];
        foreach ($data as $item){
            if($item && isset($item['item_id'])){
                if($item['item_id'] == 25){
                    $return['torpedo_silver'] = $item['item_count'];
                }
                if($item['item_id'] == 26){
                    $return['torpedo_gold'] = $item['item_count'];
                }
                if($item['item_id'] == 27){
                    $return['torpedo_diamond'] = $item['item_count'];
                }
            }
        }
        $return['silver_number'] = $return['torpedo_silver'] + $return['torpedo_gold'] * $setting['gold_torpedo_scale'] + $return['torpedo_diamond'] * $setting['diamond_torpedo_scale'];
        return $return;
    }

    protected function register($data){
        User::create(['acc' => $data['acc'], 'nickname' => $data['nickname'], 'player_id' => $data['player_id']]);
    }


    //鱼雷BUFF逻辑
    protected function buffNum($user, $torpedo){
        $setting = config('setting');
        //保底值，如果算出的结果不够保底值，则每次兑换至少给用户该值的保底
        $buffEnd = $user['buff_end'] ?: $setting['buff_end'];
        //投注中奖概率
        $probability = $user['win_probability'] ?: $setting['win_probability'];
        //弹头投放数量
        $throw = $setting['throw_torpedo'];
        //RIO 总的buff值 / 总兑换量
        $totalBuff = User::sum('buff_total');//总的buff值
        $totalConvert = User::sum('convert_total');//总兑换量
        //总奖池 总的buff值 - (总兑换量 + 投放数量) > 0 则亏损
        //总奖池：输的用户他们输的总数累积而成，用户赢的不能超过这个数量，如果我们要放出去，则用户赢的不能超过这个数量加上放出去的数量
        $jackpot = $totalBuff - $totalConvert;
        $defaultFactor = $probability;
        $totalRoi = $totalBuff == 0 ? 0 : number_format($totalBuff / $totalConvert, 2);
        $totalIncrease = $setting['effect_factor'] * $totalRoi;
        if($throw > $jackpot){
            //放出去的数量大于奖池的额度，则用户赢的还没达到我们的阈值，增加中奖几率
            $defaultFactor += $totalIncrease;
        }else{
            $defaultFactor -= $totalIncrease;
        }

        //个人RIO 个人buff值 和 个人兑换值
        $userBuff = $user['buff_total'];//个人总buff值
        $userConvert = $user['convert_total'];//个人总兑换量
        $userRoi = $userBuff == 0 ? 0 : number_format($userBuff / $userConvert, 2);
        $userIncrease = $setting['effect_factor'] * $userRoi;
        if($userBuff < $userConvert){
            //用户处于输的状态，增加中奖几率
            $defaultFactor += $userIncrease;
        }else{
            $defaultFactor -= $userIncrease;
        }

        //计算用户buff值数量,计算投注每一次的中将buff
        $buff = 0;//初始值
        for($i = 1; $i <= $torpedo; $i++){
            $buff += $this->betting($setting, $defaultFactor);
        }
        return number_format($buff, 2);
    }


    //投注
    protected function betting($setting, $probability){
        $hight = $setting['height_multiple'];
        $end = $setting['buff_end'];
        $prices = [
            ['i' => 1, 'k' => 10],
            ['i' => 2, 'k' => $probability],
            ['i' => 3, 'k' => 90 - $probability]
        ];
        $factors = [
            1 => $hight,
            2 => mt_rand(5, ($hight - $end)* 10) / 10,
            3 => mt_rand($end * 10, 5) / 10,
        ];
        $gif = [];
        foreach ($prices as $key => $val){
            $gif[$val['i']] = $val['k'];
        }
        $total = array_sum($gif);
        $factor = 0;
        foreach ($gif as $key => $val){
            $rand = mt_rand(1, $total);
            if($rand <= $val){
                $factor = $factors[$key];
                break;
            }else{
                $total -= $val;
            }
        }
        return number_format($factor, 2);
    }


    //根据鱼雷类型换算成白银鱼雷
    protected function scaler($type, $number, $setting){
        switch ($type){
            case 25: //白银鱼雷
                $torpedo = $number;
                break;
            case 26: //黄金鱼雷
                $torpedo = $number * $setting['gold_torpedo_scale'];
                break;
            case 27: //钻石鱼雷
                $torpedo = $number * $setting['diamond_torpedo_scale'];
                break;
            default:
                $torpedo = $number;
                break;
        }
        return $torpedo;
    }

}
