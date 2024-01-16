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







}
