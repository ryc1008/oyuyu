<?php

use Illuminate\Support\Facades\Route;

Route::post('/login', 'LoginController@index');//登录

Route::group(['middleware' => ['auth:admin']], function () {

    Route::group(['prefix' => 'manager'], function () {
        Route::get('/', 'ManagerController@list')->name('admin.manager.list');
        Route::get('/config', 'ManagerController@config')->name('admin.manager.config');
        Route::get('/user', 'ManagerController@user')->name('admin.manager.user');
        Route::post('/update', 'ManagerController@update')->name('admin.manager.update');
        Route::post('/lock', 'ManagerController@lock')->name('admin.manager.lock');
        Route::post('/active', 'ManagerController@active')->name('admin.manager.active');
        Route::post('/destroy', 'ManagerController@destroy')->name('admin.manager.destroy');
    });

    Route::group(['prefix' => 'role'], function () {
        Route::get('/', 'RoleController@list')->name('admin.role.list');
        Route::get('/tree', 'RoleController@tree')->name('admin.role.tree');
        Route::get('/access', 'RoleController@access')->name('admin.role.access');
        Route::post('/update', 'RoleController@update')->name('admin.role.update');
        Route::post('/destroy', 'RoleController@destroy')->name('admin.role.destroy');
    });

    Route::group(['prefix' => 'log'], function () {
        Route::get('/', 'LoginLogController@list')->name('admin.log.list');
        Route::get('/config', 'LoginLogController@config')->name('admin.log.config');
        Route::post('/check', 'LoginLogController@check')->name('admin.log.check');
        Route::post('/destroy', 'LoginLogController@destroy')->name('admin.log.destroy');
    });

    Route::group(['prefix' => 'config'], function () {
        Route::get('/', 'ConfigController@list')->name('admin.config.list');
        Route::post('/update', 'ConfigController@update')->name('admin.config.update');
    });


    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@list')->name('admin.user.list');
        Route::get('/config', 'UserController@config')->name('admin.user.config');
        Route::get('/torpedo', 'UserController@torpedo')->name('admin.user.torpedo');
        Route::get('/ticket', 'UserController@ticket')->name('admin.user.ticket');
        Route::post('/recharge', 'UserController@recharge')->name('admin.user.recharge');
        Route::post('/airdrop', 'UserController@airdrop')->name('admin.user.airdrop');
        Route::post('/update', 'UserController@update')->name('admin.user.update');
    });


    Route::group(['prefix' => 'main'], function () {
        Route::get('/month', 'IndexController@month')->name('admin.main.month');
        Route::get('/order', 'IndexController@order')->name('admin.main.order');
        Route::get('/user', 'IndexController@user')->name('admin.main.user');
        Route::get('/count', 'IndexController@count')->name('admin.main.count');
    });


});

