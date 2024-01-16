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

class TorpedoController extends Controller
{

    public function index(Request $request){
        try {
            $acc = $request->get('acc', '');
            $user = User::where('acc', $acc)->first();
            if(!$user){
                $acc = '';
            }
            $result = $this->client('torpedo_find', ['acc' => $acc]);
            $update = [
                'torpedo_silver' => 0,
                'torpedo_gold' => 0,
                'torpedo_diamond' => 0,
                'silver_number' => 0,
            ];
            $setting = config('setting');
            if($result['status'] == 200){
                foreach ($result['data']['items'] as $item){
                    if(isset($item['item_id'])){
                        if($item['item_id'] == 25){
                            $update['torpedo_silver'] = $item['item_count'];
                        }
                        if($item['item_id'] == 26){
                            $update['torpedo_gold'] = $item['item_count'];
                        }
                        if($item['item_id'] == 27){
                            $update['torpedo_diamond'] = $item['item_count'];
                        }
                    }
                }
                $update['silver_number'] = $update['torpedo_silver'] + $update['torpedo_gold'] * $setting['gold_torpedo_scale'] + $update['torpedo_diamond'] * $setting['diamond_torpedo_scale'];
                $user->update($update);
            }
            $torpedo = $update;
            return $this->returnJson(0, $torpedo);
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }

    }







}
