<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class PostController extends Controller{
    public function settubutypes(Request $request) {
        if( $request->input('tid',0) == 0 ) {
            $sql = " insert into tubutypes (name,intro,pics) values (?,?,?) ";
            $res = DB::insert($sql,[$request->input('name'),$request->input('intro'),$request->input('pics')]);
        }else{
            $sql = " update tubutypes set name=?,intro=?,pics=? where id=? ";
            $res = DB::update($sql,[$request->input('name'),$request->input('intro'),$request->input('pics'),$request->input('tid')]);
        }
        if( $res ) {
            echo "200-success";
        }else{
            echo "400-操作失败";
        }
    }
    public function deletebyid(Request $request) {
        $table = $request->input("table","none");
        $id = $request->input("id","0");
        if( $table == 'none' || $id == "0") {
            echo "400-操作失败";
        }else{
            $sql = " delete from `$table` where id=? ";
            $res = DB::delete($sql,[$id]);
            if( $table == 'user' ) {
                $sql = " delete from userattr where uid=? ";
                $res = DB::delete($sql,[$id]);
            }
            echo "200-success";
        }
    }
    public function fabuzixun(Request $request) {
        $title = $request->input("title");
        $tuwen = $request->input("tuwen");
        $pic = $request->input("pic");
        $zid = $request->input("zid","no");
        if( $zid == 'no' ) {
            $sql = " insert into zixun(title,tuwen,pic) values(?,?,?) ";
            $res = DB::insert($sql,[$title,$tuwen,$pic]);
        }else{
            $sql = " update zixun set title=?,tuwen=?,pic=? where id=? ";
            $res = DB::update($sql,[$title,$tuwen,$pic,$zid]);
        }
        if( $res ) {
            echo "200-success";
        }else{
            echo "400-操作失败";
        }
    }
    public function setbanner(Request $request) {
        if( $request->input("id","no") == 'no' ) {
            $sql = " insert into banner (title,sort,url,pic) values (?,?,?,?) ";
            $res = DB::insert($sql,[$request->input('title'),$request->input('sort'),$request->input('url'),$request->input('pic')]);
        }else{
            $sql = " update banner set title=?,sort=?,url=?,pic=? where id=? ";
            $res = DB::update($sql,[$request->input('title'),$request->input('sort'),$request->input('url'),$request->input('pic'),$request->input('id')]);
        }
        if( $res ) {
            $request->session()->forget('banners');
            echo "200-success";
        }else{
            echo "400-操作失败";
        }
    }
    public function dongjiebyid(Request $request) {
        $table = $request->input("table","none");
        $id = $request->input("id","0");
        if( $table == 'none' || $id == "0") {
            echo "400-操作失败";
        }else{
            $sql1 = " select * from `$table` where id=? ";
            $r = DB::select($sql1,[$id]);
            if( $r[0]->status == 1 ) {
                $sql = " update `$table` set status=0 where id=? ";
            }else{
                $sql = " update `$table` set status=1 where id=? ";
            }
            $res = DB::delete($sql,[$id]);
            echo "200-success";
        }
    }
    public function dofabuyouji(Request $request) {
        $title = $request->input("title");
        $tuwen = $request->input("tuwen");
        $pic = $request->input("pic");
        $id = $request->input("id","no");
        if( $id == 'no' ) {
            $sql = " insert into youji (uid,type,title,tuwen,pic) values(0,2,?,?,?) ";
            $res = DB::insert($sql,[$title,$tuwen,$pic]);
        }else{
            $sql = " update youji set title=?,tuwen=?,pic=? where id=? ";
            $res = DB::update($sql,[$title,$tuwen,$pic,$id]);
        }
        if( $res ) {
            echo "200-success";
        }else{
            echo "400-操作失败";
        }
    }
    public function fabudasai(Request $request) {
        $title = $request->input("title");
        $tuwen = $request->input("tuwen");
        $startday = $request->input("startday");
        $endday = $request->input("endday");
        $uploadend = $request->input("uploadend");
        $pic = $request->input("pic");
        $id = $request->input("id","no");
        if( $id == 'no' ) {
            $sql = " insert into dasai (endday,startday,title,tuwen,pic,uploadend) values(?,?,?,?,?,?) ";
            $res = DB::insert($sql,[$endday,$startday,$title,$tuwen,$pic,$uploadend]);
        }else{
            $sql = " update dasai set title=?,tuwen=?,pic=?,endday=?,startday=?,uploadend=? where id=? ";
            $res = DB::update($sql,[$title,$tuwen,$pic,$endday,$startday,$uploadend,$id]);
        }
        if( $res ) {
            echo "200-success";
        }else{
            echo "400-操作失败";
        }
    }
    public function shopbanner(Request $request) {
        if( $request->input("id","no") == 'no' ) {
            $sql = " insert into shopbanner (title,sort,url,pic) values (?,?,?,?) ";
            $res = DB::insert($sql,[$request->input('title'),$request->input('sort'),$request->input('url'),$request->input('pic')]);
        }else{
            $sql = " update shopbanner set title=?,sort=?,url=?,pic=? where id=? ";
            $res = DB::update($sql,[$request->input('title'),$request->input('sort'),$request->input('url'),$request->input('pic'),$request->input('id')]);
        }
        if( $res ) {
            $request->session()->forget('shopbanners');
            echo "200-success";
        }else{
            echo "400-操作失败";
        }
    }
    public function addshopsort(Request $request) {
        $title = $request->input("title",'');
        $sort = $request->input("sort",'');
        $pid = $request->input("pid",'');
        $id = $request->input("id",'');
        if( checknull($title,$sort) ) {
            if  ($pid == '') {
                if( $id == '' ) {
                    $sql = " insert into shopsort (title,sort) values (?,?) ";
                    $res = DB::insert($sql,[$title,$sort]);
                }else{
                    $sql = " update shopsort set title=?,sort=? where id=? ";
                    $res = DB::update($sql,[$title,$sort,$id]);
                }

            }else{
                $sql = " select * from shopsort where id=? ";
                $r = DB::select($sql,[$pid]);
                if( count($r) == 0 ) {
                    echo "400-父类不存在"; return;
                }else{
                    $sql = " insert into shopsubsort (title,sort,pid) values (?,?,?) ";
                    $res = DB::insert($sql,[$title,$sort,$pid]);
                }
            }
            if( $res ) {
                echo "200-success";
            }else{
                echo "400-操作失败";
            }
        }

    }
    public function singlelpage(Request $request) {
        $title = $request->input("title");
        $content = $request->input("content");
        $updateid = $request->input("updateid",0);
        if( checknull($title,$content)) {
            if( $updateid != 0 ) {
                $sql = " update singlepage set title=?,content=? where id= ?";
                $res = DB::update($sql,[$title,$content,$updateid]);
            }else{
                $sql = " insert into singlepage (title,content) values (?,?) ";
                $res = DB::insert($sql,[$title,$content]);
            }

            if( $res ) {
                echo "200-success";
            }else{
                echo "400-添加失败";
            }
        }
    }

    public function getsinglepage(Request $request) {
        $sql = " select * from singlepage where id= ?";
        $res = DB::select($sql,[$request->input('id')]);
        if( count($res) == 0 ) {
            echo "400-没有相关数据";
        }else{
            echo json_encode($res[0]);
        }
    }

    public function updateoptions(Request $request) {
        $id = $request->input('id');
        $content = $request->input('content');
        if( checknull($id,$content) ) {
            $sql = " update options set content=? where id=? ";
            $res = DB::update($sql,[$content,$id]);
            if( $res ) {
                $request->session()->forget('footer');
                $request->session()->forget('mianban');
                echo "200-success";
            }else{
                echo "400-保存失败";
            }
        }
    }
    public function addadmin(Request $request) {
        $aname = $request->input('aname');
        $passwd = $request->input('passwd');
        $adminflag = $request->input('adminflag');
        if( checknull($aname,$passwd,$adminflag) ) {
            $sql = " insert admin (aname,passwd,adminflag) values (?,?,?) ";
            $res = DB::insert($sql,[$aname,md5($passwd),$adminflag]);
            if( $res ) {
                echo "200-success";
            }else{
                echo "400-添加失败";
            }
        }
    }
    public function updatekuaidi(Request $request) {
        $id = $request->input("id");
        $kuaidi = $request->input("kuaidi");
        $sql = " update shoporder set kuaidi=? where id=? ";
        $res = DB::update($sql,[$kuaidi,$id]);
        if( $res ) {
            echo "200-success";
        }else{
            echo "400-操作失败";
        }
    }

    public function edittubupaixu(Request $request)
    {
        $id = $request->input("id");
        $paixu = $request->input("paixu");
        $sql = " update tubuhuodong set paixu=? where id=? ";
        $res = DB::update($sql,[$paixu,$id]);
        if( $res ) {
            echo "200-success";
        }else{
            echo "400-操作失败";
        }
    }

    public function fenche(Request $request){
        $tid = $request->input("tid");
        $fenche = $request->input("fenche");
        $order_ids = $request->input("order_ids");
        if( checknull($tid,$order_ids) ) {
            $sql = " update tubuorder set fenche='".$fenche."' where tid=".$tid." and id in (".$order_ids.") ";
            $res = DB::update($sql);
            if( $res ) {
                echo "200-success";
            }else{
                echo "400-error";
            }
        }
    }
    public function addtubuorder(Request $reqeust) {

    }
    public function adduser(Request $request) {
        $phone = $request->input('phone');
        $sql = "select * from user where phone=?";
        $res = DB::select($sql,[$phone]);
        if( count($res) > 0 ) {
            echo "400-手机号码已被注册";
        }else {
            $sql = " insert into user (phone,passwd,regip) values (?,?,?) ";
            $res = DB::insert($sql,[$phone,md5($phone),"adminInsert"]);
            if( $res ) {
                $sql = "select * from user where phone=?";
                $res = DB::select($sql,[$phone]);
                if( count($res) > 0 ) {
                    $sql = " insert into userattr (uid) values (?) ";
                    $res = DB::insert($sql,[$res[0]->id]);
                }
                echo "200-success";
            }else{
                echo "400-添加出错";
            }
        }
    }
    public function changepasswd(Request $request) {
        $passwd = $request->input('passwd');
        $uid = $request->input('uid');
        $sql = " update user set passwd=? where id=? ";
        $res = DB::update($sql,[md5($passwd),$uid]);
        if( $res ) {
            echo "200-修改成功";
        }else{
            echo "400-修改无效";
        }
    }
    public function addorder(Request $request) {
        $tid = $request->input("tid",'');
        $realname = $request->input("realname",'');
        $mobile = $request->input("mobile",'');
        $youkes = $request->input("youkes",'');
        $num = $request->input("num",'');
        $jihe = $request->input("jihe",'');
        $mark = $request->input("mark",'') == ''?"无":$request->input("mark",'');
        $userphone = $request->input("userphone",'');
        $sql = " select * from user where phone=? ";
        $res = DB::select($sql,[$userphone]);
        if( count($res) == 0 ) {
            echo "400-会员手机号不存在"; return ;
        }else{
            $uid = $res[0]->id;
        }

        $sql = " insert into tubuorder (uid,tid,jihe,mobile,num,mark,youkes,realname) values (?,?,?,?,?,?,?,?) ";
        $res = DB::insert($sql,[$uid,$tid,$jihe,$mobile,$num,$mark,$youkes,$realname]);
        if( $res ) {
            echo "200-添加成功";
//                添加报名人数
            @DB::table('tubuhuodong')->where('id', $tid)->increment('baoming' ,1);

//                添加常用游客
            $youkearr = json_decode($youkes);
            for( $i=0;$i<count($youkearr);$i++ ) {
                $sql = "insert into youkes (uid,name,mobile,idcard) values (?,?,?,?) ";
                DB::insert($sql,[$uid,$youkearr[$i]->name,$youkearr[$i]->mobile,$youkearr[$i]->idcard]);
            }
        }else{
            echo "400-报名失败，请联系客服";
        }
    }
    public function tubumiandan(Request $request) {
        $id = $request->input("id");
        $sql = " update tubuorder set orderid=? where id=? ";
        $res = DB::update($sql,["免费订单",$id]);
        if( $res ) {
            echo "200-操作成功";
        }else{
            echo "400-操作失败";
        }
    }
    public function tubuvisible($tid) {
        $sql = " select * from tubuhuodong where id=? ";
        $res = DB::select($sql,[$tid]);
        if( count($res) ) {
            $sql =  " update tubuhuodong set visible=? where id=? ";
            $res = DB::update($sql,[$res[0]->visible == "1" ? "0" : "1",$tid]);
            if( $res ){
                echo "200-success";
            }else{
                echo "400-操作失败";
            }
        }
    }

    public function copytubu($tid) {
        $sql = " insert into tubuhuodong (title,tuwen,types,howlong,startday,endday,price,mudidi,jingdian,neirong,jihetime,jihedidian,qiangdu,juli,jiaotong,need,jiezhi,baoming,phone,leader,pictures,tese,paixu,ptime,visible) select title,tuwen,types,howlong,startday,endday,price,mudidi,jingdian,neirong,jihetime,jihedidian,qiangdu,juli,jiaotong,need,jiezhi,0,phone,leader,pictures,tese,paixu,ptime,0 from tubuhuodong where id=?  ";
        $res = DB::insert($sql,[$tid]);
        if( $res ){
            echo "200-success";
        }else{
            echo "400-操作失败";
        }
    }
}