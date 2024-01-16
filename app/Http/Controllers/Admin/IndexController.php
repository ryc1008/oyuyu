<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends Controller {

    public function month(Request $request){
        try {
            $date = $request->get('date', 0);
            //当月最后一天
            $lastDay = Carbon::parse($date)->endOfMonth()->format('d');
            $dayData = [];
            $count = [];
            for($i = 1; $i <= $lastDay; $i++){
                if($i < 10){
                    $dayData[] = sprintf("%02d", $i);
                    $count[] = rand(10, 150) ;
                }else{
                    $dayData[] = "$i";
                    $count[] = 0;
                }
            }
            return $this->returnJson(0, [
                'day' => $dayData,
                'money' => $count
            ]);
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }


    //是否BOSS，ACC，倍数，掉落区间
    //兑换给buff值
    //总池子数量，个人设置
    //BOSS必掉，黄金鱼几率掉
    //












































}
