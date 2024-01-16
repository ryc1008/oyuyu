<?php

namespace App\Models;

class Role extends Base
{

    protected $fillable = [
        'id', 'title', 'brief', 'rules', 'created_at', 'updated_at'
    ];

    protected $casts = [
        'rules' => 'array'
    ];


    protected function list($params = [], $fields = ['*'], $limit = 0)
    {
        $this->limit =  $limit ?: $this->limit;
        return $this->select($fields)
            ->where(function ($query) use ($params) {
                if (isset($params['kwd']) && $params['kwd']) {
                    $query->where('title', 'like', '%' . $params['kwd'] . '%');
                }
            })
            ->orderBy('id', 'desc')
            ->paginate($this->limit);
    }


    protected function tree(){
        return $this->select(['id','title'])
            ->orderBy('id', 'asc')
            ->get();
    }



}
