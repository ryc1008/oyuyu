<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    const STATUS_1 = 1;
    const STATUS_2 = 2;

    const STATUS_TEXT = [
        self::STATUS_1 => '正常',
        self::STATUS_2 => '锁定',
    ];

    protected $fillable = [
        'id', 'username', 'nickname', 'avatar', 'rid', 'password', 'status', 'created_at', 'updated_at'
    ];


    protected $hidden = [
        'password'
    ];

    public function role(){
        return $this->belongsTo('App\Models\Role','rid', 'id');
    }

    protected function list($params = [], $fields = ['*'], $limit = 10)
    {
        $limit =  $limit ?: config('setting.limit');
        return $this->select($fields)
            ->where(function ($query) use ($params) {
                if (isset($params['kwd']) && $params['kwd']) {
                    $query->where('username', 'like', '%' . $params['kwd'] . '%')
                        ->orWhere('nickname', 'like', '%' . $params['kwd'] . '%');
                }
                if (isset($params['status']) && $params['status']) {
                    $query->where('status', $params['status']);
                }
                if (isset($params['rid']) && $params['rid']) {
                    $query->where('rid', $params['rid']);
                }
            })->with([
                'role' => function ($query) {$query->select('id', 'title');}
            ])
            ->orderBy('id', 'desc')
            ->paginate($limit);
    }




    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return ['role' => 'admin'];
    }

}
