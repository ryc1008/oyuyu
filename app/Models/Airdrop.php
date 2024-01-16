<?php

namespace App\Models;

class Airdrop extends Base
{
    const STATUS_1 = 1;
    const STATUS_2 = 2;

    const STATUS_TEXT = [
        self::STATUS_1 => '未兑换',
        self::STATUS_2 => '已兑换',
    ];


    const TYPE_1 = 25;
    const TYPE_2 = 26;
    const TYPE_3 = 27;

    const TYPE_TEXT = [
        self::TYPE_1 => '白银鱼雷',
        self::TYPE_2 => '黄金鱼雷',
        self::TYPE_3 => '钻石鱼雷',
    ];

    protected $fillable = [
        'id', 'acc_publish', 'acc_accept', 'number', 'name', 'type', 'redeem_code', 'status', 'created_at', 'updated_at'
    ];



    protected function list($params = [], $fields = ['*'], $limit = 10)
    {
        $this->limit =  $limit ?: $this->limit;
        return $this->select($fields)
            ->where(function ($query) use ($params) {
                if (isset($params['kwd']) && $params['kwd']) {
                    $query->where('acc_publish', 'like', '%' . $params['kwd'] . '%');
                }
                if (isset($params['status']) && $params['status']) {
                    $query->where('status', $params['status']);
                }
            })
            ->orderBy('status', 'desc')
            ->paginate($this->limit);
    }


}
