<?php

use Illuminate\Support\Facades\Log;

//流水号
function order(){
    return date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 10);
}


//状态转化
function state_to_text(&$data, $arr = []){
    foreach ($data as $key => &$row) {
        foreach ($arr as $k => $val) {
            if (isset($row[$k]) && isset($val[$row[$k]])) {
                $text = $k . '_text';
                $row[$text] = $val[$row[$k]];
            }
        }
    }
    return $data;
}

//日志
function loger($name = '', $message = '', $level = 0){
    switch ($level){
        case 1:
            Log::info($name, [$message]);
            break;
        default:
            Log::error($name, [$message]);
            break;
    }
}


//兑换码
function redeem_code(){
    $code = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $rand = $code[rand(0,25)]
        .strtoupper(dechex(date('m')))
        .date('d').substr(time(),-5)
        .substr(microtime(),2,5)
        .sprintf('%02d',rand(0,99));
    for(
        $a = md5( $rand, true ),
        $s = '0123456789ABCDEFGHIJKLMNOPQRSTUV',
        $d = '',
        $f = 0;
        $f < 8;
        $g = ord( $a[ $f ] ),
        $d .= $s[ ( $g ^ ord( $a[ $f + 8 ] ) ) - $g & 0x1F ],
        $f++
    );
    return $d;
}
