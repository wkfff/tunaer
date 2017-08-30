<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller{

    public function index() {

        return view('admin.index');
    }
    public function login() {
        Session::forget('adminflag');
        return view('admin.login');
    }

    public function dologin(Request $request) {
        $aname = $request->input("uname");
        $passwd = $request->input("passwd");
        if( !checknull($aname,$passwd) ) {
            echo "400-信息不完整";return ;
        }
        $sql = " select * from admin where aname=? and passwd=? ";
        $res = DB::select($sql,[$aname,md5($passwd)]);
        if( count($res) == 0 ) {
            echo "400-用户名或密码错误";return ;
        }
        Session::put("aname",$res[0]->aname);
        Session::put("adminflag",$res[0]->adminflag);
        echo "200-登录成功";

    }
//    用户列表
    public function userlist(Request $request){
        $page = $request->input('page',1);
        $num = $request->input('num',20);
        $r = DB::select(" select count(*) as cnt from user ");
        $count = $r[0]->cnt;
        $sql = " select user.id as userid,user.phone,user.status,userattr.* from user left join userattr on user.id=userattr.uid order by id desc limit ".($page-1)*$num.", ".$num;
        $res = DB::select($sql);
        return view("admin.userlist",['userlist'=>$res,"count"=>$count]);
    }
    public function fabutubu() {
        return view("admin.fabutubu");
    }
}