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
        return view("admin.userlist",['list'=>$res,"count"=>$count]);
    }

    public function fabutubu() {
        $types = DB::select("select * from tubutypes");
        return view("admin.fabutubu",["types"=>$types]);
    }
    public function updatetubu($tubuid) {

        $sql = " select * from tubuhuodong where id=? ";
        $res = DB::select($sql,[$tubuid]);
        $types = DB::select("select * from tubutypes");
        if( count($res) == 0 ) {
            return view("web.error",["content"=>'活动id不存在']);
        }else{
            return view("admin.updatetubu",["tubu"=>$res[0],"types"=>$types]);
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
//        $sql = " insert into tubuhuodong (title,tuwen,types,howlong,startday,endday,price,mudidi,jingdian,neirong,jihetime,jihedidian,qiangdu,  jiaotong,need,phone,leader,pictures,juli,tese) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
        $title = $request->input('title');
        $tuwen = $request->input('tuwen');
        $types = $request->input('types');
        $howlong = $request->input('howlong');
        $startday = $request->input('startday');
        $endday = $request->input('endday');
        $price = $request->input('price');
        $mudidi = $request->input('mudidi');
        $jingdian = $request->input('jingdian');
        $neirong = $request->input('neirong');
        $jihetime = $request->input('jihetime');
        $jihedidian = $request->input('jihedidian');
        $qiangdu = $request->input('qiangdu');
        $jiaotong = $request->input('jiaotong');
        $need = $request->input('need');
        $phone = $request->input('phone');
        $leader = $request->input('leader');
        $pictures = $request->input('pictures');
        $juli = $request->input('juli');
        $tese = $request->input('tese');
        $sql = " insert into tubuhuodong (title,tuwen,types,howlong,startday,endday,price,mudidi,jingdian,neirong,jihetime,jihedidian,qiangdu,jiaotong,need,phone,leader,pictures,juli,tese) values ('".$title."','".$tuwen."','".$types."','".$howlong."','".$startday."','".$endday."','".$price."','".$mudidi."','".$jingdian."','".$neirong."','".$jihetime."','".$jihedidian."','".$qiangdu."','".$jiaotong."','".$need."','".$phone."','".$leader."','".$pictures."','".$juli."','".$tese."') ";
        $res = DB::insert($sql,[]);
        if( $res ) {
            echo "200";
        }else{
            echo "400-发布失败";
        }
    }
    public function doupdatetubu(Request $request) {
        $sql = " update tubuhuodong set title=?,tuwen=?,types=?,howlong=?,startday=?,endday=?,price=?,mudidi=?,jingdian=?,neirong=?,jihetime=?,jihedidian=?,qiangdu=?,jiaotong=?,need=?,phone=?,leader=?,pictures=?,juli=?,tese=? where id=?";
        $res = DB::update($sql,[$request->input('title'),$request->input('tuwen'),$request->input('types'),$request->input('howlong'),$request->input('startday'),$request->input('endday'),$request->input('price'),$request->input('mudidi'),$request->input('jingdian'),$request->input('neirong'),$request->input('jihetime'),$request->input('jihedidian'),$request->input('qiangdu'),$request->input('jiaotong'),$request->input('need'),$request->input('phone'),$request->input('leader'),$request->input('pictures'),$request->input('juli'),$request->input('tese'),$request->input('tubuid')]);
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
        $sql = " select tubuhuodong.*,tubutypes.name as typename from tubuhuodong left join tubutypes on tubutypes.id=tubuhuodong.types order by id desc limit ".($page-1)*$num.", ".$num;
        $res = DB::select($sql);
        return view("admin.tubulist",['tubulist'=>$res,"count"=>$count]);
    }
    public function fabuproduct() {
        return view("admin.fabuproduct");
    }

    public function dofabuproduct(Request $request) {
        $sql = " insert into product (title,tuwen,sort,price,sold,youfei,kucun,colorlist,chicunlist,pictures) values (?,?,?,?,?,?,?,?,?,?) ";
        $res = DB::insert($sql,[$request->input('title'),$request->input('tuwen'),$request->input('sort'),$request->input('price'),$request->input('sold'),$request->input('youfei'),$request->input('kucun'),$request->input('colorlist'),$request->input('chicunlist'),$request->input('pictures')]);
        if( $res ) {
            echo "200";
        }else{
            echo "400-发布失败";
        }
    }
    public function productlist(Request $request) {
        $page = $request->input('page',1);
        $num = $request->input('num',20);
        $r = DB::select(" select count(*) as cnt from product ");
        $count = $r[0]->cnt;
        $sql = " select * from product order by id desc limit ".($page-1)*$num.", ".$num;
        $res = DB::select($sql);
        return view("admin.productlist",['list'=>$res,"count"=>$count]);
    }
    public function updateproduct($pid) {
        $sql = " select * from product where id=? ";
        $res = DB::select($sql,[$pid]);
        if( count($res) == 0 ) {
            return view("web.error",["content"=>'商品不存在']);
        }else{
            return view("admin.updateproduct",["data"=>$res[0]]);
        }
    }
    public function doupdateproduct(Request $request) {
        $sql = " update product set title=?,tuwen=?,sort=?,price=?,sold=?,youfei=?,kucun=?,colorlist=?,chicunlist=?,pictures=? where id=? ";
        $res = DB::insert($sql,[$request->input('title'),$request->input('tuwen'),$request->input('sort'),$request->input('price'),$request->input('sold'),$request->input('youfei'),$request->input('kucun'),$request->input('colorlist'),$request->input('chicunlist'),$request->input('pictures'),$request->input('pid')]);
        if( $res ) {
            echo "200";
        }else{
            echo "400-没有做任何修改";
        }
    }
    public function adminlist() {
        $sql = " select * from admin ";
        $res = DB::select($sql);
        return view("admin/adminlist",["list"=>$res]);
    }
    public function settubutypes() {
        $sql = " select * from tubutypes ";
        $res = DB::select($sql);
        return view("admin.setting.tubutypes",["list"=>$res]);
    }
    public function zixunlist(Request $request) {
        $page = $request->input("page",1);
        $num = $request->input("num",20);
        $json = $request->input("json","no");
        $sql = " select * from zixun order by id desc limit ?,?";
        $res = DB::select($sql,[($page-1)*$num,$num]);
        if( $json == "no" ) {
            return view("admin.zixunlist",["list"=>$res]);
        }else{
            echo json_encode($res);
        }
    }
    public function fabuzixun() {
        return view("admin.fabuzixun");
    }
    public function updatezixun($id) {
        $sql = " select * from zixun where id=? ";
        $res = DB::select($sql,[$id]);
        if( count($res) == 0 ) {
            return view("web.error",["content"=>'资讯不存在']);
        }else{
            return view("admin.updatezixun",["data"=>$res[0]]);
        }

    }
    public function setbanner() {
        $sql = " select * from banner order by id desc";
        $res = DB::select($sql);
        return view("admin.setting.banner",["list"=>$res]);
    }
    public function monidenglu($userid) {
        $sql = " select user.*,userattr.uname from user left join userattr on user.id=userattr.uid where user.id=?";
        $res = DB::select($sql,[$userid]);
        Session::put('uid', $res[0]->id);
        Session::put('uname', $res[0]->uname);
        return redirect("/user/".$userid);
    }
    public function fabudasai(){
        return view("admin.fabudasai");
    }
    public function fabuyouji() {
        return view("admin.fabuyouji");
    }
    public function updateyouji($id) {
        $sql = " select * from youji where id=? ";
        $res = DB::select($sql,[$id]);
        if( count($res) == 0 ) {
            return view("web.error",["content"=>'游记不存在']);
        }else{
            return view("admin.updateyouji",["data"=>$res[0]]);
        }

    }
    public function youjilist(Request $request) {
        $page = $request->input("page",1);
        $num = $request->input("num",7);
        $count = DB::select(" select count(*) as cnt from youji ");
        $sql = " select * from youji order by id desc limit ?,? ";
        $res = DB::select($sql,[($page-1)*$num,$num]);
        return view("admin.youjilist",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/admin/youjilist",$page,$num)]);
    }
    public function youjilist2(Request $request,$type=1) {
        $page = $request->input("page",1);
        $num = $request->input("num",7);
        $count = DB::select(" select count(*) as cnt from youji where type= ".$type);
        $sql = " select * from youji where type=? order by id desc limit ?,? ";
        $res = DB::select($sql,[$type,($page-1)*$num,$num]);
        return view("admin.youjilist",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/admin/youjilist",$page,$num)]);
    }
    public function dasailist(Request $request) {
        $page = $request->input("page",1);
        $num = $request->input("num",7);
        $count = DB::select(" select count(*) as cnt from dasai ");
        $sql = " select * from dasai order by id desc limit ?,? ";
        $res = DB::select($sql,[($page-1)*$num,$num]);
        return view("admin.dasailist",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/admin/dasailist",$page,$num)]);
    }
    public function updatedasai($id) {
        $sql = " select * from dasai where id=? ";
        $res = DB::select($sql,[$id]);
        if( count($res) == 0 ) {
            return view("web.error",["content"=>'大赛不存在']);
        }else{
            return view("admin.updatedasai",["data"=>$res[0]]);
        }
    }
    public function shopbanner() {
//        die("999");
        $sql = " select * from shopbanner order by id desc";
        $res = DB::select($sql);
        return view("admin.setting.shopbanner",["list"=>$res]);
    }
}