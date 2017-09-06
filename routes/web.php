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
//    banner
    Route::get('/setting/banner', 'IndexController@setbanner');
    Route::post('/setting/banner', 'PostController@setbanner');

//    资讯列表
    Route::get('/zixunlist', 'IndexController@zixunlist');
    Route::get('/monidenglu/{userid}', 'IndexController@monidenglu');
//    发布资讯
    Route::get('/fabuzixun', 'IndexController@fabuzixun');
    Route::post('/dofabuzixun', 'PostController@fabuzixun');
    Route::get('/updatezixun/{id}', 'IndexController@updatezixun');

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
    Route::post('/dongjiebyid', 'PostController@dongjiebyid');
});
//前台页面  不需要认证的前端页面
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
    Route::get('/', 'IndexController@index');
    Route::post('/register','IndexController@register');
    Route::post('/login','IndexController@login');
    Route::post('/sendcode','IndexController@sendcode');
    Route::get('/verifycode', 'IndexController@verifycode');
    Route::get('/outlogin', 'IndexController@outlogin');
    Route::get('/user/{userid}', 'IndexController@user');
    Route::get('/tubulist/{type}', 'IndexController@tubulist');
    Route::get('/tubu/tubudetail/{tid}', 'IndexController@tubudetail');
    Route::get('/member/list', 'IndexController@memberlist');
    Route::get('/member/dongtai', 'IndexController@dongtai');
    Route::get('/zixun', 'IndexController@zixun');
    Route::post('/tubu/huodongtuijian', 'PostController@huodongtuijian');
    Route::post("/dongtai/cmlist","PostController@dongtaicmlist");

});
// 获取头像
Route::get("/head/{userid}","Web\PostController@userhead");
// 需要登录访问的api
Route::group(['namespace'=>'Web',"middleware"=>'logined'],function(){
    Route::post("/updateuserinfo","PostController@updateuserinfo");
    Route::post("/updatehead","PostController@updatehead");
    Route::post("/tubu/baoming","PostController@baoming");
    Route::post("/fabudongtai","PostController@fabudongtai");
    Route::post("/uploadimg","PostController@uploadimg");
    Route::post("/fadongtai","PostController@fadongtai");
    Route::post("/dongtai/pinglun","PostController@dongtaicm");

    Route::post("/youji/fabu","PostController@fabuyouji");

});
