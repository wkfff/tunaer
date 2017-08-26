<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login',function(){
    return view('web.login');
});
Route::get('/register',function(){
    return view('web.register');
});
Route::get('/error',function(){
    return view('web.error');
});

Route::group(['namespace' => 'Web'], function()
{
    Route::get('/', 'IndexController@index');
    Route::post('/register','IndexController@register');
    Route::post('/login','IndexController@login');
    Route::post('/sendcode','IndexController@sendcode');
    Route::get('/verifycode', 'IndexController@verifycode');
    Route::get('/outlogin', 'IndexController@outlogin');
    Route::get('/user', 'IndexController@user');
});
