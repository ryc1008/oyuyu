<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Demand;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use QL\QueryList;

class UserController extends Controller
{

    public function login(Request $request){
        try {
            $data = $request->all();
            $user = User::where('acc', $data['acc'])->first();
            if(!$user){
                $this->register($data);
            }
            return $this->returnJson(0);
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }

    }

    public function vip(Request $request){
        try {
            $acc = $request->get('acc', '');
            $user = User::where('acc', $acc)->first();
            if($user){
                return $this->returnJson(0, $user['vip_exp']);
            }
            return $this->returnJson(1, null, 'system error');
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }





}
