<?php

namespace App\Console\Commands;

use App\Models\Demand;
use Illuminate\Console\Command;

class DemandExpire extends Command
{

    protected $signature = 'demand:expire';

    protected $description = '处理截止时间到期的需求';


    public function handle()
    {
        $ids = Demand::where('cutoff_at', '<', date('Y.m.d'))
            ->where('status', Demand::STATUS_1)
            ->get('id')->implode('id', ',');
        if($ids){
            Demand::store(explode(',', $ids), ['status' => Demand::STATUS_2]);
        }
//        loger('lists', $ids);
    }
}
