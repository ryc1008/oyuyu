<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'IndexController@index')->where('any', '.*');
Route::get('/{any}', 'IndexController@index')->where('any', '.*');

