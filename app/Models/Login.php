<?php

namespace App\Models;

class Login extends Base
{

    const STATUS_1 = 1;
    const STATUS_2 = 2;

    const STATUS_TEXT = [
        self::STATUS_1 => '正常',
        self::STATUS_2 => '异常',
    ];

    protected $fillable = [
        'id', 'status', 'username', 'password', 'address', 'ip', 'login_at'
    ];

    public $timestamps = false;




    protected function list($params = [], $fields = ['*'], $limit = 0)
    {
        $this->limit =  $limit ?: $this->limit;
        return $this->select($fields)
            ->where(function ($query) use ($params) {
                if (isset($params['status']) && $params['status']) {
                    $query->where('status', $params['status']);
                }
                if (isset($params['kwd']) && $params['kwd']) {
                    $query->where('username', 'like', '%' . $params['kwd'] . '%')
                        ->orWhere('ip', 'like', '%' . $params['kwd'] . '%');
                }
            })->orderBy('login_at', 'desc')
            ->paginate($this->limit);
    }


}
