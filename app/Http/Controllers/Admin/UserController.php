<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Airdrop;
use App\Models\Cost;
use App\Models\Dossier;
use App\Models\Family;
use App\Models\Region;
use App\Models\Report;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class UserController extends Controller
{

    //配置项
    public function config(){
        try {
            $config =  [
                'status' => User::STATUS_TEXT,
                'identity' => User::IDENTITY_TEXT,
                'item' => User::ITEM_TEXT,
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
            $lists = User::list($param);
            state_to_text($lists, [
                'identity' => User::IDENTITY_TEXT,
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
            $info = User::findOrFail($data['id']);
            if(!$info){
                return $this->returnJson(1, null, '用户信息不存在');
            }
            $info->update($data);
            return $this->returnJson(0);
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

    //空投
    public function airdrop(Request $request){
        try {
            $data = $request->all();
            $info = User::findOrFail($data['id']);
            if(!$info){
                return $this->returnJson(1, null, '用户信息不存在');
            }
            $post = [
                'acc' => $data['acc'],
                'item_id' => $data['item'],
                'num' => $data['number'],
            ];
            $setting = config('setting');
            $result = $this->client('torpedo_update', $post, 'POST');
            if($result['status'] == 200){
                $insert = [
                    'torpedo_silver' => 0,
                    'torpedo_gold' => 0,
                    'torpedo_diamond' => 0,
                    'silver_number' => 0,
                ];
                foreach ($result['data']['items'] as $item){
                    if($item['item_id'] == 25){
                        $insert['torpedo_silver'] = $item['item_count'];
                    }
                    if($item['item_id'] == 26){
                        $insert['torpedo_gold'] = $item['item_count'];
                    }
                    if($item['item_id'] == 27){
                        $insert['torpedo_diamond'] = $item['item_count'];
                    }
                }
                $insert['silver_number'] = $insert['torpedo_silver'] + $insert['torpedo_gold'] * $setting['gold_torpedo_scale'] + $insert['torpedo_diamond'] * $setting['diamond_torpedo_scale'];
                $info->update($insert);
                //创建记录
                Airdrop::create([
                    'acc_publish' => 'system',
                    'acc_accept' => $data['acc'],
                    'type' => $data['item'],
                    'number' => $data['number'],
                    'redeem_code' => redeem_code(),
                    'status' => Airdrop::STATUS_2
                ]);
                return $this->returnJson(0, $result['data']);
            }
            return $this->returnJson(1, null, $result['msg']);
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

    //鱼雷
    public function torpedo(Request $request){
        try {
            $data = $request->all();
            $info = User::findOrFail($data['id']);
            if(!$info){
                return $this->returnJson(1, null, '用户信息不存在');
            }
            $post = [
                'acc' => $info['acc'],
            ];
            $result = $this->client('torpedo_find', $post);
            return $this->returnJson(0, $result);
            if($result['status'] == 200){
                return $this->returnJson(0, $result['data']);
            }
            return $this->returnJson(1, null, $result['msg']);
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

    //话费
    public function ticket(Request $request){
        try {
            $data = $request->all();
            $info = User::findOrFail($data['id']);
            if(!$info){
                return $this->returnJson(1, null, '用户信息不存在');
            }
            $post = [
                'acc' => $info['acc'],
            ];
            $result = $this->client('ticket_find', $post);
            if($result['status'] == 200){
                $info->update([
                    'nickname' => $result['data']['nickName'],
                    'player_id' => $result['data']['playerId'],
                    'ticket' => $result['data']['ticket']
                ]);
                return $this->returnJson(0);
            }
            return $this->returnJson(1, null, $result['msg']);
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

    //充值
    public function recharge(Request $request){
        try {
            $data = $request->all();
            $info = User::findOrFail($data['id']);
            if(!$info){
                return $this->returnJson(1, null, '用户信息不存在');
            }
            $post = [
                'acc' => $data['acc'],
                'score' => $data['number'],
            ];
            $result = $this->client('ticket_recharge', $post, 'POST');
            if($result['status'] == 200){
                $info->update([
                    'ticket' => $result['data']['ticket']
                ]);
                return $this->returnJson(0, $result['data']);
            }
            return $this->returnJson(1, null, $result['msg']);
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }


    public function aa(){
        /**
         * 总池子数
         * 单个兑换设置buff值
         * boss必掉 黄金鱼几率掉
         * 掉落
         * 固定30%给用户，不裸奔
         * ROI
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         *
         */









    }




}
