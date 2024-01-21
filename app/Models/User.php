<?php

namespace App\Models;


class User extends Base
{

    const STATUS_1 = 1;
    const STATUS_2 = 2;

    const STATUS_TEXT = [
        self::STATUS_1 => '正常',
        self::STATUS_2 => '锁定',
    ];


    const IDENTITY_1 = 1;
    const IDENTITY_2 = 2;

    const IDENTITY_TEXT = [
        self::IDENTITY_1 => '用户',
        self::IDENTITY_2 => '代理',
    ];

    const ITEM_1 = 25;
    const ITEM_2 = 26;
    const ITEM_3 = 27;

    const ITEM_TEXT = [
        self::ITEM_1 => '白银鱼雷',
        self::ITEM_2 => '黄金鱼雷',
        self::ITEM_3 => '钻石鱼雷',
    ];


    protected $fillable = [
        'id', 'acc', 'nickname', 'player_id', 'identity', 'vip', 'vip_exp', 'ticket', 'status', 'fish_drop', 'buff_num', 'buff_end',
        'win_probability', 'lucky_number', 'convert_total', 'buff_total', 'consume_total',
        'torpedo_silver', 'torpedo_gold', 'torpedo_diamond', 'silver_number', 'created_at', 'updated_at'
    ];



    protected function list($params = [], $fields = ['*'], $limit = 10)
    {
        $this->limit =  $limit ?: $this->limit;
        return $this->select($fields)
            ->where(function ($query) use ($params) {
                if (isset($params['kwd']) && $params['kwd']) {
                    $query->where('player_id', 'like', '%' . $params['kwd'] . '%');
                }
                if (isset($params['status']) && $params['status']) {
                    $query->where('status', $params['status']);
                }
                if (isset($params['identity']) && $params['identity']) {
                    $query->where('identity', $params['identity']);
                }
            })
            ->orderBy('identity', 'desc')
            ->orderBy('id', 'desc')
            ->paginate($this->limit);
    }


}
