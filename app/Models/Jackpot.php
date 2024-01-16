<?php

namespace App\Models;


class Jackpot extends Base
{


    protected $fillable = [
        'id', 'acc', 'buff', 'created_at', 'updated_at'
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
