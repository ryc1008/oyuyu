<?php

use Illuminate\Support\Facades\Route;


Route::get('/', 'IndexController@index')->name('web.index.index');

Route::group(['prefix' => 'airdrop'], function(){
    Route::get('/', 'AirdropController@index');
    Route::get('/test', 'AirdropController@test')->name('airdrop.test');//测试游戏
    Route::get('/demo', 'AirdropController@demo')->name('airdrop.demo');//测试游戏
    Route::get('/iframe', 'AirdropController@iframe')->name('airdrop.iframe');//主页
    Route::post('/update', 'AirdropController@update')->name('airdrop.update');//空投
    Route::get('/record', 'AirdropController@record')->name('airdrop.record');;//记录
    Route::post('/redeem', 'AirdropController@redeem')->name('airdrop.redeem');;//兑换码
});

Route::group(['prefix' => 'diamond'], function(){
    Route::get('/iframe', 'DiamondController@iframe')->name('diamond.iframe');//主页
    Route::post('/update', 'DiamondController@update')->name('diamond.update');//兑换
});

Route::group(['prefix' => 'gold'], function(){
    Route::get('/iframe', 'GoldController@iframe')->name('gold.iframe');//主页
    Route::post('/update', 'GoldController@update')->name('gold.update');//兑换
});

Route::group(['prefix' => 'vip'], function(){
    Route::get('/iframe', 'VipController@iframe')->name('vip.iframe');//主页
    Route::post('/update', 'VipController@update')->name('vip.update');//兑换
});

Route::group(['prefix' => 'user'], function(){
    Route::post('/login', 'UserController@login')->name('user.login');
    Route::get('/vip', 'AirdropController@vip')->name('user.vip');;//VIP
});

Route::group(['prefix' => 'torpedo'], function(){
    Route::get('/', 'TorpedoController@index')->name('torpedo.index');//鱼雷
});

