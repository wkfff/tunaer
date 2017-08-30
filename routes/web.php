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



//后台页面前缀
Route::get('/admin/login', 'Admin\IndexController@login');
Route::post('/admin/dologin', 'Admin\IndexController@dologin');

//后台入口 无前缀
Route::group(['middleware' => 'v6auth','namespace'=>'Admin'], function() {
    Route::get('/v6', 'IndexController@index');
});
//后台所有页面需要检查　登录情况　由 v6auth中间件　负责
Route::group(['middleware' => 'v6auth','prefix' => 'admin','namespace'=>'Admin'], function()
{
    Route::get('/index', 'IndexController@index');
    Route::get('/userlist', 'IndexController@userlist');
//    发布徒步
    Route::get('/fabutubu', 'IndexController@fabutubu');
});
//前台页面
Route::group(['namespace' => 'Web'], function()
{
    Route::get('/login',function(){
        return view('web.login');
    });
    Route::get('/register',function(){
        return view('web.register');
    });
    Route::get('/error',function(){
        return view('web.error');
    });
    // 获取头像
    Route::get("/head/{userid}","ApiController@getuserhead");
    Route::get('/', 'IndexController@index');
    Route::post('/register','IndexController@register');
    Route::post('/login','IndexController@login');
    Route::post('/sendcode','IndexController@sendcode');
    Route::get('/verifycode', 'IndexController@verifycode');
    Route::get('/outlogin', 'IndexController@outlogin');
    Route::get('/user/{userid}', 'IndexController@user');

});
// 获取头像
Route::get("/head/{userid}","Api\IndexController@userhead");
// 需要登录访问的api
Route::group(['namespace'=>'Api',"middleware"=>'logined'],function(){
    Route::post("/updateuserinfo","IndexController@updateuserinfo");
    Route::post("/updatehead","IndexController@updatehead");
});
