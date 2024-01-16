<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cost;
use App\Models\User;
use Illuminate\Http\Request;
use Mews\Captcha\Facades\Captcha;

class GameController extends Controller {

    /*
     * 弹头掉落接口
     * 金币消耗换算成鱼雷，设定一个阈值，超过阈值和boss一样必掉，保证使用的多也能掉的多或者至少能掉
     * 金币余额和buff值对比作为一个系数
     * 设定一个幸运值，保证多少次能掉完，记录一个字段
     */
    public function falling(Request $request){
        $data = $request->all();
        return $this->buyuJson(0, $data, '恭喜您, 获得11个黄金鱼雷');



        $setting = config('setting');
        //$setting['throw_torpedo']; $setting['fish_drop']; $setting['buff_end']; $setting['lucky_limit'];
        $user = User::where('acc', $data['acc'])->find();
        //没有buff值了，不用在管
        if($user['buff_num'] < 1){
            return $this->returnJson(0, 0);
        }
        //普通鱼类掉落弹头率
        $drop = $setting['fish_drop'];
        //幸运上限，到上限值时，buff值还没掉落完，则全部给用户
        //保证多少次能掉完，记录一个字段
        $lucky = $user['lucky_number'] ?: $setting['lucky_number'];
        //判断是否是BOSS,boss必掉
        if(!$data['is_boss']){
            $return = $this->factor($data['mul'], $setting['throw_torpedo'], $user['id']);
            return $this->returnJson(0, $return);
        }else{
            $lucky = $user['lucky_limit'] ?: $setting['lucky_limit'];
            $jiang = $this->betting($lucky);
            if($jiang){
                $return = $this->factor($data['mul'], $setting['throw_torpedo'], $user['id']);
                return $this->returnJson(0, $return);
            }else{
                return $this->returnJson(0, 0);
            }
        }
    }




    protected function deduction($percent = 0){
        //设置总概率为10
        $t = 10;
        //计算扣量所占总概率的比重
        $d = $percent / $t;
        //随机从1到总概率之间取一个值
        $r = mt_rand(1, $t);
        if($r > $d){
            return false;//结算
        }
        return true;//扣量
    }







}
