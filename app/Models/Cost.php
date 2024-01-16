<?php

namespace App\Models;


class Cost extends Base
{

    const GROUP_1 = 1;
    const GROUP_2 = 2;
    const GROUP_3 = 3;
    const GROUP_4 = 4;

    const GROUP_TEXT = [
        self::GROUP_1 => '兑换金币',
        self::GROUP_2 => '兑换钻石',
        self::GROUP_3 => '兑换会员',
        self::GROUP_4 => '鱼雷掉落',
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
        'id', 'acc', 'uid', 'number', 'type', 'group', 'redeem_number', 'created_at', 'updated_at'
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
            ->paginate($this->limit);
    }


}
