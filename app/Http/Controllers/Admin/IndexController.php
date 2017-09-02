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
//    登录
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
    public function updatetubu($tubuid) {

        $sql = " select * from tubuhuodong where id=? ";
        $res = DB::select($sql,[$tubuid]);
        if( count($res) == 0 ) {
            return view("web.error",["content"=>'活动id不存在']);
        }else{
            return view("admin.updatetubu",["tubu"=>$res[0]]);
        }

    }
//    上传图片
    public function uploadimg(Request $request) {
        $file = $request->file('file');
        if ($file->isValid()) {
            $imgname = time() .".". $file->getClientOriginalExtension();
            $destinationPath = base_path() . "/public/admin/data/images/";

            if( $file->move($destinationPath,$imgname) ) {
                // 返回图片名
                echo $imgname;
            }else{
                echo 400;
            }
        }
    }
//    发布徒步活动
    public function dofabutubu(Request $request) {
        $sql = " insert into tubuhuodong (title,tuwen,types,howlong,startday,endday,price,mudidi,jingdian,neirong,jihetime,jihedidian,qiangdu,  jiaotong,need,phone,leader,pictures) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
        $res = DB::insert($sql,[$request->input('title'),$request->input('tuwen'),$request->input('types'),$request->input('howlong'),$request->input('startday'),$request->input('endday'),$request->input('price'),$request->input('mudidi'),$request->input('jingdian'),$request->input('neirong'),$request->input('jihetime'),$request->input('jihedidian'),$request->input('qiangdu'),$request->input('jiaotong'),$request->input('need'),$request->input('phone'),$request->input('leader'),$request->input('pictures')]);
        if( $res ) {
            echo "200";
        }else{
            echo "400-发布失败";
        }
    }
    public function doupdatetubu(Request $request) {
        $sql = " update tubuhuodong set title=?,tuwen=?,types=?,howlong=?,startday=?,endday=?,price=?,mudidi=?,jingdian=?,neirong=?,jihetime=?,jihedidian=?,qiangdu=?,jiaotong=?,need=?,phone=?,leader=?,pictures=? where id=?";
        $res = DB::update($sql,[$request->input('title'),$request->input('tuwen'),$request->input('types'),$request->input('howlong'),$request->input('startday'),$request->input('endday'),$request->input('price'),$request->input('mudidi'),$request->input('jingdian'),$request->input('neirong'),$request->input('jihetime'),$request->input('jihedidian'),$request->input('qiangdu'),$request->input('jiaotong'),$request->input('need'),$request->input('phone'),$request->input('leader'),$request->input('pictures'),$request->input('tubuid')]);
        if( $res ) {
            echo "200";
        }else{
            echo "400-没有做任何修改";
        }
    }

    public function tubulist(Request $request) {
        $page = $request->input('page',1);
        $num = $request->input('num',20);
        $r = DB::select(" select count(*) as cnt from tubuhuodong ");
        $count = $r[0]->cnt;
        $sql = " select * from tubuhuodong order by id desc limit ".($page-1)*$num.", ".$num;
        $res = DB::select($sql);
        return view("admin.tubulist",['tubulist'=>$res,"count"=>$count]);
    }
    public function fabuproduct() {
        return view("admin.fabuproduct");
    }
}