<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Demand;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Artisan;
use QL\QueryList;

class IndexController extends Controller
{

    public function index(){
//        $vipExp = 50001;
//        $exps = [0, 10, 100, 200, 500, 1000, 2000, 5000, 10000, 20000, 50000];
//        $records = array_filter($exps, function ($item) use($vipExp){
//            return $item <= $vipExp;
//        });
//        $vip = array_search(max($records), $records);;
//        dump($maxKey);
    }

//    protected function level($vipExp){
//        $exps = [10, 100, 200, 500, 1000, 2000, 5000, 10000, 20000, 50000];
//        $records = array_filter($exps, function ($item) use($vipExp){
//            return $item < $vipExp;
//        });
//    }








}
