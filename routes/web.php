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

//后台页面　不需要登录
Route::get('/admin/login', 'Admin\IndexController@login');
Route::post('/admin/dologin', 'Admin\IndexController@dologin');
//后台入口 无前缀
Route::group(['middleware' => 'v6auth','namespace'=>'Admin'], function() {
    Route::get('/v6', 'IndexController@index');
});
//后台所有页面需要检查　登录情况　由 v6auth中间件　负责
Route::group(['middleware' => 'v6auth','prefix' => 'admin','namespace'=>'Admin'], function()
{
//    后台首页
    Route::get('/index', 'IndexController@index');
//    会员列表
    Route::get('/userlist', 'IndexController@userlist');
//    发布徒步
    Route::get('/fabutubu', 'IndexController@fabutubu');
//    发布商品
    Route::get('/fabuproduct', 'IndexController@fabuproduct');
//    徒步列表
    Route::get('/tubulist', 'IndexController@tubulist');
//    商品列表
    Route::get('/productlist', 'IndexController@productlist');
//    编辑徒步
    Route::get('/updatetubu/{tubuid}', 'IndexController@updatetubu');
//    编辑商品
    Route::get('/updateproduct/{tubuid}', 'IndexController@updateproduct');
//    管理员列表
    Route::get('/adminlist', 'IndexController@adminlist');
//    设置徒步分类
    Route::get('/setting/tubutypes', 'IndexController@settubutypes');
//    上传照片
    Route::post('/uploadimg', 'IndexController@uploadimg');
//    发布徒步活动
    Route::post('/dofabutubu', 'IndexController@dofabutubu');
//    更新徒步
    Route::post('/doupdatetubu', 'IndexController@doupdatetubu');
//    更新商品
    Route::post('/doupdateproduct', 'IndexController@doupdateproduct');
//    发布商品
    Route::post('/dofabuproduct', 'IndexController@dofabuproduct');
//    设置徒步分类
    Route::post('/setting/settubutypes', 'PostController@settubutypes');
    Route::post('/deletebyid', 'PostController@deletebyid');
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
    Route::get('/tubulist/{type}', 'IndexController@tubulist');
    Route::get('/tubu/tubudetail/{tid}', 'IndexController@tubudetail');

});
// 获取头像
Route::get("/head/{userid}","Api\IndexController@userhead");
// 需要登录访问的api
Route::group(['namespace'=>'Api',"middleware"=>'logined'],function(){
    Route::post("/updateuserinfo","IndexController@updateuserinfo");
    Route::post("/updatehead","IndexController@updatehead");
});
