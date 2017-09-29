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
    Route::post('/addshopsort', 'PostController@addshopsort');

//    资讯列表
    Route::get('/zixunlist', 'IndexController@zixunlist');
    Route::get('/monidenglu/{userid}', 'IndexController@monidenglu');
//    发布资讯
    Route::get('/fabuzixun', 'IndexController@fabuzixun');
    Route::post('/dofabuzixun', 'PostController@fabuzixun');
    Route::get('/updatezixun/{id}', 'IndexController@updatezixun');
    Route::get('/setting/shopbanner', 'IndexController@shopbanner');
    Route::post('/setting/shopbanner', 'PostController@shopbanner');
    Route::post('/updatekuaidi', 'PostController@updatekuaidi');
    Route::get('/setting/shopfenlei', 'IndexController@shopfenlei');
    Route::get('/shoporder', 'IndexController@shoporder');
    Route::get('/tubuorder', 'IndexController@tubuorder');

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
    Route::post('/singlelpage', 'PostController@singlelpage');
    Route::get('/fabudasai', 'IndexController@fabudasai');
    Route::post('/fabudasai', 'PostController@fabudasai');
    Route::get('/fabuyouji', 'IndexController@fabuyouji');
    Route::get('/updateyouji/{id}', 'IndexController@updateyouji');
    Route::post('/dofabuyouji', 'PostController@dofabuyouji');
    Route::get('/youjilist', 'IndexController@youjilist');
    Route::get('/youjilist/{type}', 'IndexController@youjilist2');
    Route::get('/dasailist', 'IndexController@dasailist');
    Route::get('/updatedasai/{id}', 'IndexController@updatedasai');
    Route::get('/singlepage', 'IndexController@singlepage');
    Route::get('/setting/editfooter', 'IndexController@editfooter');
    Route::get('/setting/mianban', 'IndexController@mianban');
    Route::get('/getsinglepage', 'PostController@getsinglepage');
    Route::post('/updateoptions', 'PostController@updateoptions');
    Route::post("/addadmin","PostController@addadmin");
});
//Access Key ID	Access Key Secret	状态	创建时间	操作
//LTAICyYaKmLyh9sj
//fh7VDi4xBUIQPY4H13eAfVx88kfwaP 隐藏

//前台页面  不需要认证的前端页面
Route::group(['namespace' => 'Web'], function()
{
    Route::get('/qianjiahui','IndexController@qianjiahui');
    Route::get('/login','IndexController@login');
    Route::get('/register','IndexController@register');
    Route::get('/error','IndexController@error');
    Route::get('/', 'IndexController@index');
    Route::post('/register','PostController@register');
    Route::post('/login','PostController@login');
    Route::post('/sendcode','PostController@sendcode');
    Route::get('/verifycode', 'PostController@verifycode');
    Route::get('/outlogin', 'IndexController@outlogin');
    Route::get('/user/{userid}', 'IndexController@user');
    Route::get('/tubulist/{type?}', 'IndexController@tubulist');
    Route::get('/tubu/tubudetail/{tid}', 'IndexController@tubudetail');
    Route::get('/member/list', 'IndexController@memberlist');
    Route::get('/member/dongtai', 'IndexController@dongtai');
    Route::get('/zixun', 'IndexController@zixun');
    Route::post('/tubu/huodongtuijian', 'PostController@huodongtuijian');
    Route::post("/dongtai/cmlist","PostController@dongtaicmlist");
    Route::get("/zixun/detail/{id}","IndexController@zixundetail");
    Route::get("/youjilist/{type}","IndexController@youjilist");
    Route::get("/youji/detail/{id}","IndexController@youjidetail");
    Route::get("/dasai/{id?}","IndexController@dasai");
    Route::get("/shops","IndexController@shops");
    Route::post("/getyoujicms","PostController@getyoujicms");
    Route::post("/getchatlist","PostController@getchatlist");
    Route::post("/getphotos","PostController@getphotos");
    Route::post("/getdongtais","PostController@getdongtais");
    Route::post("/getliuyans","PostController@getliuyans");
    Route::post("/getyoujis","PostController@getyoujis");
    Route::post("/recenttubu","PostController@recenttubu");
    Route::get("/monilogin/{userid}","IndexController@monilogin");
    Route::get("/shop/detail/{id}","IndexController@shopdetail");
    Route::get("/shops/key/{key}","IndexController@searchkey");
    Route::get("/shops/sort/{sort}","IndexController@searchsort");
    Route::get("/goumai","IndexController@goumai");
    Route::get("/gouwuche","IndexController@gouwuche");
    Route::get("/shoporder","IndexController@shoporder");
    Route::get("/chatlist","IndexController@chatlist");
    Route::get("/chatpage/{userid}","IndexController@chatpage");
    Route::get("/searchtubu","IndexController@searchtubu");
    Route::get("/single/{id}","IndexController@singlepage");

    // 获取头像
    Route::get("/head/{userid?}","PostController@userhead");
});

// 需要登录访问的api
Route::group(['namespace'=>'Web',"middleware"=>'logined'],function(){
    Route::post("/updateuserinfo","PostController@updateuserinfo");
    Route::post("/updatehead","PostController@updatehead");
    Route::post("/tubu/baoming","PostController@baoming");
    Route::post("/fabudongtai","PostController@fabudongtai");
    Route::post("/uploadimg","PostController@uploadimg");
    Route::post("/fadongtai","PostController@fadongtai");
    Route::post("/dongtai/pinglun","PostController@dongtaicm");
    Route::post("/toupiao","PostController@toupiao");
    Route::post("/uploadxiangce","PostController@uploadxiangce");
    Route::post("/liuyan","PostController@liuyan");
    Route::post("/zhaohu","PostController@zhaohu");
    Route::post("/youji/fabu","PostController@fabuyouji");
    Route::post("/sendchat","PostController@sendchat");
    Route::post("/getchathistory","PostController@getchathistory");
    Route::post("/canjiadasai","PostController@canjiadasai");
    Route::post("/xiadan","PostController@xiadan");
    Route::post("/getshoporders","PostController@getshoporders");
    Route::post("/gettubuorders","PostController@gettubuorders");
    Route::post("/delchat/{userid}","PostController@delchat");

    Route::post("/youjicm","PostController@youjicm");


});


//前台页面  不需要认证的前端页面
Route::group(['namespace' => 'Wap'], function(){
    Route::get('/index', 'IndexController@index');
});