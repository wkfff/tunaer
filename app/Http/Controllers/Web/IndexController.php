<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    public function index() {
        $sql = " select * from tubuhuodong order by id desc limit 10";
        $tubus = DB::select($sql);
        $sql = " select user.id as userid,userattr.* from user inner join userattr on user.id=userattr.uid where user.status=1 and userattr.head<>'' order by user.id desc limit 12";
        $users = DB::select($sql);
        $sql = " select * from youji where type=1 order by id desc limit 10 ";
        $youjis = DB::select($sql);
        $sql = " select * from zixun order by id desc limit 6 ";
        $zixuns = DB::select($sql);
        return view("web.index",["tubus"=>$tubus,"users"=>$users,"youjis"=>$youjis,"zixuns"=>$zixuns]);
    }

    public function login() {
        return view('web.login');
    }
    public function register() {
        return view('web.register');
    }
    public function error() {
        return view('web.error');
    }
    // 退出登录
    public function outlogin() {
        Session::forget('uid');
        // return view('web.error');
        return redirect($_SERVER['HTTP_REFERER']);
    }

    public function user($userid) {
        $sql = " select user.id as userid,userattr.* from user left join userattr on user.id=userattr.uid where user.status=1 and user.id=? ";
        $res = DB::select($sql,[$userid]);
        //动态
//        $sql = " select dongtai.* from dongtai inner join user on user.id=dongtai.uid where dongtai.uid=? order by dongtai.id desc limit 100 ";
//        $dongtai = DB::select($sql,[$userid]);
//        相册
//        $sql = " select * from xiangce where uid=? ";
//        $xiangce = DB::select($sql,[$userid]);
//        留言
//        $sql = " select * from liuyan where tid=? order by id desc ";
//        $liuyan = DB::select($sql,[$userid]);
        if( count($res) == 0 ) {
            return view("web.error",['content'=>'用户不存在']);
        }else{
            return view('web.user',["userinfo"=>$res[0]]);
        }

    }
    public function tubulist(Request $request,$type=null) {
        $page = $request->input('page',1);
        $num = $request->input('num',7);
        if( $type ) {
            $count = DB::select("select count(*) as cnt from tubuhuodong left join tubutypes on tubutypes.id=tubuhuodong.types where types=".$type);
            $sql = " select tubuhuodong.*,tubutypes.pics,tubutypes.intro,tubutypes.name from tubuhuodong left join tubutypes on tubutypes.id=tubuhuodong.types where types=? order by tubuhuodong.id desc limit ".($page-1)*$num.", ".$num;;
            $res = DB::select($sql,[$type]);
        }else{
            $count = DB::select("select count(*) as cnt from tubuhuodong left join tubutypes on tubutypes.id=tubuhuodong.types ");
            $sql = " select tubuhuodong.*,tubutypes.pics,tubutypes.intro,tubutypes.name from tubuhuodong left join tubutypes on tubutypes.id=tubuhuodong.types order by tubuhuodong.id desc limit ".($page-1)*$num.", ".$num;;
            $res = DB::select($sql);
        }

        $sql = " select * from youji order by rand() limit 5 ";
        $youjis = DB::select($sql);
        return view("web.tubulist",["list"=>$res,"youjis"=>$youjis,"cnt"=>$count[0]->cnt,"fenye"=>fenye($count[0]->cnt,"/tubulist/".$type,$page,$num)]);

    }
    public function tubudetail($tid) {
        $sql = " select tubuhuodong.*,tubutypes.name from tubuhuodong left join tubutypes on tubutypes.id=tubuhuodong.types where tubuhuodong.id=? ";
        $res = DB::select($sql,[$tid]);
        if( count($res) == 0 ) {
            return view("web.error",['content'=>"没有找到相关内容"]);
        }else{
            @DB::table("tubuhuodong")->where("id",$tid)->increment("readcnt",1);
            return view("web.tubudetail",['detail'=>$res[0]]);
        }
    }
    public function memberlist(Request $request) {
        $page = $request->input("page",1);
        $num = $request->input("num",24);
        $ajax = $request->input("ajax","no");
        $sex = $request->input("sex","");
        $addr = $request->input("addr","");
        $age = $request->input("age","");
        $mryst = $request->input("mryst","");
        $where = "";
        $search='?';
        if( $sex != '' ) {
            $where .= " and sex='".$sex."' ";
            $search .= "&sex=".$sex;
        }
        if( $addr != '' && $addr != '-' ) {
            $where .= " and addr like '%".$addr."%' ";
            $search .= "&addr=".$addr;
        }
        if( $age != '' ) {
            $age1 = explode("-",$age);
            $where .= " and age>".$age1[0]." and age < ".$age1[1];
            $search .= "&age=".$age;
        }
        if( $mryst != '' ) {
            $where .= " and mryst='".$mryst."' ";
            $search .= "&mryst=".$mryst;
        }
        if( $search != '?' ) {
            $search .= "&";
        }
        $count = DB::select("select count(*) as cnt from user left join userattr on user.id=userattr.uid where user.status=1 ".$where);
//        exit("select user.id as userid,userattr.* from user left join userattr on user.id=userattr.uid where user.status=1 ".$where);
        $sql = " select user.id as userid,userattr.* from user left join userattr on user.id=userattr.uid where user.status=1 ".$where." order by user.id desc limit ?,? ";
        $res = DB::select($sql,[($page-1)*$num,$num]);
        if( $ajax == 'no' ) {
            return view("web.memberlist",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/member/list",$page,$num,$search)]);
        }else{
            echo json_encode($res);
        }
    }
    public function dongtai(Request $request) {
        $page = $request->input("page",1);
        $num = $request->input("num",7);
        $ajax = $request->input("ajax","no");
        $count = DB::select(" select count(*) as cnt from dongtai inner join user on user.id=dongtai.uid ");
        $sql = " select dongtai.* from dongtai inner join user on user.id=dongtai.uid order by dongtai.id desc limit ?,? ";
        $res = DB::select($sql,[($page-1)*$num,$num]);
        if( $ajax == 'no' ) {
            return view("web.dongtai",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/member/dongtai",$page,$num)]);
        }else{
            echo json_encode($res);
        }
    }
    public function zixun(Request $request) {
        $page = $request->input("page",1);
        $num = $request->input("num",10);
        $ajax = $request->input("ajax","no");
        $count = DB::select(" select count(*) as cnt from zixun ");
        $sql = " select * from zixun order by id desc limit ?,? ";
        $res = DB::select($sql,[($page-1)*$num,$num]);
        if( $ajax == 'no' ) {
            return view("web.zixun",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/zixun",$page,$num)]);
        }else{
            echo json_encode($res);
        }
    }
    public function zixundetail($id) {
        $sql = " select * from zixun where id=? ";
        $res = DB::select($sql,[$id]);
        @DB::table("zixun")->where("id",$id)->increment("readcnt",1);
        $sql = " select * from zixun order by rand() limit 5 ";
        $zixuns = DB::select($sql);
        return view("web.zixundetail",['list'=>$res[0],"zixuns"=>$zixuns]);
    }

    public function youjilist(Request $request,$type=1) {
        $page = $request->input("page",1);
        $num = $request->input("num",10);
        $count = DB::select(" select count(*) as cnt from youji where type= ".$type);
        $sql = " select * from youji where type=? order by id desc limit ?,? ";
        $res = DB::select($sql,[$type,($page-1)*$num,$num]);
        return view("web.youjilist",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/youjilist/".$type,$page,$num)]);
    }
    public function youjidetail($id) {
        $sql = " select youji.*,userattr.uname from youji left join userattr on userattr.uid=youji.uid where youji.id=? ";
        $res = DB::select($sql,[$id]);
        @DB::table("youji")->where("id",$id)->increment("readcnt",1);
        $sql = " select * from youji order by rand() limit 5 ";
        $youjis = DB::select($sql);
        if( count($res) == 0 ) {
            return view("web.error",["content"=>"游记不存在"]);
        }
        return view("web.youjidetail",["list"=>$res[0],"youjis"=>$youjis]);
    }

    public function dasai(Request $request,$id=null) {
        $sql = " select * from dasai order by id desc limit 1 ";
        if( $id ) {
            $sql = " select * from dasai where id= ".$id;
        }
        $res = DB::select($sql);
        if( count($res) == 0 ) {
            return view("web.error",["content"=>"内容不存在"]);
        }else{
            @DB::table("dasai")->where("id",$res[0]->id)->increment("readcnt",1);
            $page = $request->input("page",1);
            $num = $request->input("num",9);
            $count = DB::select(" select count(*) as cnt from works where did= ".$res[0]->id);
            $zongpiao = DB::select(" select sum(depiao) as zong from works where did= ".$res[0]->id);
            $sql = " select * from works where did=? order by depiao desc limit ?,? ";
            $works = DB::select($sql,[$res[0]->id,($page-1)*$num,$num]);
            return view("web.dasai",["num"=>$num,"page"=>$page,"data"=>$res[0],"zongcanjia"=>$count[0]->cnt,"zongpiao"=>$zongpiao[0]->zong,"works"=>$works,"fenye"=>fenye($count[0]->cnt,"/dasai",$page,$num)]);
        }
    }

    public function shops(Request $request) {
        $page = $request->input("page",1);
        $num = $request->input("num",12);
        $count = DB::select(" select count(*) as cnt from product ");
        $sql = " select * from product order by sold desc,id desc limit ?,?  ";
        $res = DB::select($sql,[($page-1)*$num,$num]);
        $sql = " select shopsort.*,shopsubsort.id as subid,shopsubsort.pid,shopsubsort.title as subtitle,shopsubsort.sort as subsort from shopsort left join shopsubsort on shopsort.id=shopsubsort.pid order by shopsort.sort desc,shopsubsort.sort desc ";
        $fenlei = DB::select($sql);
        return view("web.shops",["fenlei"=>json_encode($fenlei),"list"=>$res,"fenye"=>fenye($count[0]->cnt,"/shops",$page,$num)]);

    }

    public function monilogin($userid) {
        $sql = " select user.*,userattr.uname from user left join userattr on user.id=userattr.uid where user.id=?  ";
        $res = DB::select($sql,[$userid]);
        Session::put('uid', $res[0]->id);
        Session::put('uname', $res[0]->uname);
        return redirect("/user/".$res[0]->id);
    }

    public function shopdetail($id) {
        $sql = " select * from product where id=? ";
        $res = DB::select($sql,[$id]);
        if( count($res) == 0 ) {
            return view("web.error",["content"=>"商品不存在或已下架"]);
        }else{
            $sql = " select * from product order by rand() limit 5 ";
            $tuijian = DB::select($sql);
            return view("web.shopdetail",["detail"=>$res[0],"tuijian"=>$tuijian]);
        }
    }

    public function searchkey(Request $request,$key) {

        $page = $request->input("page",1);
        $num = $request->input("num",12);
        $count = DB::select(" select count(*) as cnt from product where title like '%".addslashes($key)."%' ");
        $sql = " select * from product where title like '%".addslashes($key)."%' order by sold desc,id desc limit ?,?  ";
        $res = DB::select($sql,[($page-1)*$num,$num]);
//        dd($res);
        $sql = " select shopsort.*,shopsubsort.id as subid,shopsubsort.pid,shopsubsort.title as subtitle,shopsubsort.sort as subsort from shopsort left join shopsubsort on shopsort.id=shopsubsort.pid order by shopsort.sort desc,shopsubsort.sort desc ";
        $fenlei = DB::select($sql);
        return view("web.shops",["fenlei"=>json_encode($fenlei),"list"=>$res,"fenye"=>fenye($count[0]->cnt,"/shops/key/".$key,$page,$num)]);
    }
    public function searchsort(Request $request,$sort) {
        $sort = addslashes($sort);
//        搜索大分类
        if( !strpos($sort,"_") ) {
            $where = " sort= ".addslashes($sort);
        }else{
            $tmp = explode("_",$sort);
            $where = " sort=".$tmp[0]." and subsort= ".$tmp[1];
        }
        $page = $request->input("page",1);
        $num = $request->input("num",12);
        $count = DB::select(" select count(*) as cnt from product where ".$where);
        $sql = " select * from product where ".$where." order by sold desc,id desc limit ?,?  ";
        $res = DB::select($sql,[($page-1)*$num,$num]);
//        dd($res);
        $sql = " select shopsort.*,shopsubsort.id as subid,shopsubsort.pid,shopsubsort.title as subtitle,shopsubsort.sort as subsort from shopsort left join shopsubsort on shopsort.id=shopsubsort.pid order by shopsort.sort desc,shopsubsort.sort desc ";
        $fenlei = DB::select($sql);
        return view("web.shops",["fenlei"=>json_encode($fenlei),"list"=>$res,"fenye"=>fenye($count[0]->cnt,"/shops/sort/".$sort,$page,$num)]);
    }

    public function goumai(Request $request) {
        $id = $request->input("id",'');
        $chicun = $request->input("chicun",'');
        $color = $request->input("color",'');
        $num = $request->input("num",'');
        if( checknull($id,$chicun,$color,$num) ) {
            $sql = " select * from product where id=? ";
            $res = DB::select($sql,[$id]);
            if( count($res) ) {
                return view("web.goumai",["data"=>$res[0],"color"=>$color,"chicun"=>$chicun,"num"=>$num]);
            }else{
                return view("web.error",["content"=>"商品不存在或已下架"]);
            }
        }

    }
    public function gouwuche() {
        return view("web.gouwuche");
    }

    public function shoporder(Request $request) {
        if( !Session::get('uid') ) {
            return redirect($_SERVER['HTTP_REFERER']);
        }else{
            $userid = Session::get("uid");
            $page = $request->input("page",1);
            $num = $request->input("num",5);
            $sql = " select shoporder.*,product.title,product.pictures,product.price from shoporder left join product on product.id=shoporder.shopid where shoporder.uid=? order by shoporder.id desc limit ?,? ";
            $shoporder = DB::select($sql,[$userid,($page-1)*$num,$num]);
            $count = DB::select("select count(*) as cnt from shoporder left join product on product.id=shoporder.shopid where shoporder.uid=".$userid);
            return view("web.shoporder",["list"=>$shoporder,"fenye"=>fenye($count[0]->cnt,"/shoporder",$page,$num)]);
        }
    }

    public function chatlist(Request $request) {
        if( !Session::get('uid') ) {
            return redirect($_SERVER['HTTP_REFERER']);
        }
        $page = $request->input("page",1);
        $num = $request->input("num",60);
        $uid = Session::get('uid');

        $sql = " select t.*,userattr.uname from
                (
                    select uid,content,stime,isread,fid from 
                    (
                        (select id,tid as uid,content,stime,isread,fid from chat where fid=".$uid." group by tid) 
                        union all 
                        (select id,tid as uid,content,stime,isread,fid from chat where tid=".$uid." group by fid)
                        order by stime desc
                    )
                    as tmp group by tmp.uid order by tmp.stime desc limit 99
                ) as t inner join userattr on t.uid=userattr.uid where t.uid<>".$uid;

        $res = DB::select($sql);
//        dd($res);
        $sql2 = " select count(*) as cnt from
                (
                    select id,uid,content,stime,isread from 
                    (
                        (select id,tid as uid,content,stime,isread from chat where fid=".$uid." group by tid) 
                        union all 
                        (select id,tid as uid,content,stime,isread from chat where tid=".$uid." group by fid)
                        order by stime desc
                    )
                    as tmp group by tmp.uid order by tmp.stime desc limit 99
                ) as t inner join userattr on t.uid=userattr.uid where t.uid<>".$uid;
        $count = DB::select($sql2);

        return view("web.chatlist",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/chatlist",$page,$num)]);
    }

    public function chatpage($userid) {

        $sql = " select * from userattr where uid=? ";
        $res = DB::select($sql,[$userid]);
        if( count($res) == 0 ) {
            return view("web.error",["content"=>"用户不存在"]);
        }else{
            return view("web.chatpage",["userinfo"=>$res[0]]);
        }

    }

    public function searchtubu(Request $request) {
        $key = $request->input('key');
        $page = $request->input("page",1);
        $num = $request->input("num",6);
        $sql = " select * from tubuhuodong where title like '%".$key."%' or mudidi like '%".$key."%' or jingdian like '%".$key."%' or leader like '%".$key."%' ";
        $res = DB::select($sql);
        $sql2 = " select count(*) as cnt from tubuhuodong where title like '%".$key."%' or mudidi like '%".$key."%' or jingdian like '%".$key."%' or leader like '%".$key."%' ";
        $count = DB::select($sql2);
        return view("web.searchtubu",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/searchtubu",$page,$num,"?key=".$key."&")]);
    }
    
}
