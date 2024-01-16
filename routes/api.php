<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'upload'], function(){
    Route::post('/image', 'UploadController@image');
    Route::post('/file', 'UploadController@file');
});



Route::get('/captcha', 'CaptchaController@index');

Route::get('/falling', 'GameController@falling');
