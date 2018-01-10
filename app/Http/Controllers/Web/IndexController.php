<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{

    public function index(Request $request) {
//        echo getsignature("http://localhost:8080/");
//        return;
        $sql = " select * from tubuhuodong where visible=1 order by paixu desc,id desc limit 10";
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
        $sql = " select user.id as userid,proxy,userattr.* from user left join userattr on user.id=userattr.uid where user.status=1 and user.id=? ";
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
            $count = DB::select("select count(*) as cnt from tubuhuodong left join tubutypes on tubutypes.id=tubuhuodong.types where visible=1 and types=".$type);
            $sql = " select tubuhuodong.*,tubutypes.pics,tubutypes.intro,tubutypes.name from tubuhuodong left join tubutypes on tubutypes.id=tubuhuodong.types where  visible=1 and  types=? order by paixu desc,id desc limit ".($page-1)*$num.", ".$num;;
            $res = DB::select($sql,[$type]);
        }else{
            $count = DB::select("select count(*) as cnt from tubuhuodong left join tubutypes on tubutypes.id=tubuhuodong.types where  visible=1 ");
            $sql = " select tubuhuodong.*,tubutypes.pics,tubutypes.intro,tubutypes.name from tubuhuodong left join tubutypes on tubutypes.id=tubuhuodong.types where  visible=1  order by paixu desc,id desc limit ".($page-1)*$num.", ".$num;;
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
//            增加活动浏览量
            @DB::table("tubuhuodong")->where("id",$tid)->increment("readcnt",1);
//            update tubuhuodong's baoming number
            $sql = " select sum(num) as cnt from tubuorder where orderid<>'' and orderid<>'0' and tid=? " ;
            $rr = DB::select($sql,[$tid]);
            //if( $rr[0]->cnt != $res[0]->baoming ) {
                $sql = " update tubuhuodong set baoming=? where id=? ";
                @DB::update($sql,[$rr[0]->cnt,$tid]);
                $sql = " select tubuhuodong.*,tubutypes.name from tubuhuodong left join tubutypes on tubutypes.id=tubuhuodong.types where tubuhuodong.id=? ";
                $res = DB::select($sql,[$tid]);
           // }

//            检查这个用户有没有报名
            $isjoined = false;
            $phone = "";
            if( Session::get("uid") ) {

                $sql = " select * from tubuorder where uid=? and tid=? and del=0 ";
                $r = DB::select($sql,[Session::get("uid"),$tid]);

                if( count($r) >= 1 ) {
                    if( $r[0]->orderid == '0' ) {
                        if(time() - strtotime("+2 hours",strtotime($r[0]->ordertime)) >=0 ) {
                            $sql3 = " update tubuorder set del=1 where id=? ";
                            DB::update($sql3,[$r[0]->id]);
                        }else{
                            $phone = "<a href='/user/".Session::get('uid')."#huodong' style='background: #E83888;color:#fff;display:inline-block;height:35px;text-decoration: none;cursor: pointer;width:90px;text-align: center;line-height:35px;font-size:16px;border-radius:1px;'>去付款</a><span style='margin-left:10px;color:#888;font-size:14px;'>".date("H点i分",strtotime("+2 hours",strtotime($r[0]->ordertime)))." 后自动取消报名</span>";
                            $isjoined = true;
                        }
                    }else{
                        $phone = "<span class='glyphicon glyphicon-earphone' style='height:30px;width:30px;border:2px solid orange;border-radius:15px;text-align:center;margin-right:10px;font-size:24px;' ></span><span style='color:orange;font-size:24px;font-weight: bold;line-height:40px;'>".$res[0]->phone."</span>";
                        $isjoined = true;
                    }


                }
            }
            return view("web.tubudetail",['detail'=>$res[0],"isjoined"=>$isjoined,"phone"=>$phone]);
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
                        (select id,tid as uid,content,stime,isread,fid from chat where fid=".$uid." ) 
                        union all 
                        (select id,tid as uid,content,stime,isread,fid from chat where tid=".$uid." )
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
                        (select id,tid as uid,content,stime,isread from chat where fid=".$uid." ) 
                        union all 
                        (select id,tid as uid,content,stime,isread from chat where tid=".$uid." )
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

    public function singlepage($id) {
        $sql = " select * from singlepage where id=? ";
        $res = DB::select($sql,[$id]);
        if( count($res) == 0 ) {
            return view("web.error",["content"=>"内容不存在"]);
        }else{
            return view("web.single",["data"=>$res[0]]);
        }
    }
    public function qianjiahui() {
        return view("wap.qianjiahui");
    }
    public function doqianjiahui(Request $request) {
        $name = $request->input('name');
        $chepai = $request->input('chepai');
        $phone = $request->input('phone');
        $pri = $request->input('pri');
        $city = $request->input('city');
        $hasjuzhuzheng = $request->input('hasjuzhuzheng');
        $needjuzhuzheng = $request->input('needjuzhuzheng');
        $yunying = $request->input('yunying');
//        检查手机号是否重复
        $sql = " select * from qianjiahui where phone=? ";
        $r = DB::select($sql,[$phone]);
        if( count($r) > 0 ) {
            return view('wap.res',["content"=>"请勿重复提交,耐心等待通知"]);
        }
//        检查ip恶意注册
//        $sql = " select * from qianjiahui where ip=? ";
//        $r = DB::select($sql,[$_SERVER['REMOTE_ADDR']]);
//        if( count($r) > 10 ) {
//            echo "提交成功,请等待通知"; return ;
//        }

        $sql = " insert into qianjiahui (name,chepai,phone,pri,city,hasjuzhuzheng,needjuzhuzheng,yunying) values (?,?,?,?,?,?,?,?) ";
        $res = DB::insert($sql,[$name,$chepai,$phone,$pri,$city,$hasjuzhuzheng,$needjuzhuzheng,$yunying]);
        if( $res ) {
            return view('wap.res',["content"=>"提交成功,请等待通知"]);
        }else{
            return view('wap.res',["content"=>"提交成功,请等待通知"]);
        }
    }
    public function qianjiahuilist(Request $request) {
        $page = $request->input("page",1);
        $num = $request->input("num",20);
        $sql = " select * from qianjiahui order by id desc limit ?,? ";
        $res = DB::select($sql,[($page-1)*$num,$num]);
        $count = DB::select("select count(*) as cnt from qianjiahui");
        return view("wap.qianjiahuilist",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/v9",$page,$num),"count"=>$count[0]->cnt]);
    }

    public function qqlogin(Request $request) {
        return view("web.qqlogin");
    }
    public function wxlogin(Request $request) {
        $code = $request->input('code');
        $data = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx10106332de6f9840&secret=4954bacf787c59654e7b8571831a5d38&code=".$code."&grant_type=authorization_code");
        $arr = json_decode($data);
        $openid = $arr->openid;
        $token = $arr->access_token; //这个地方获取到的是网页授权access_token,和普通的access_token 不一样
        $info = file_get_contents("https://api.weixin.qq.com/sns/userinfo?access_token=".$token."&openid=".$openid."&lang=zh_CN");
        $userinfo = json_decode($info);
        return view("web.wxlogin",["userinfo"=>$userinfo]);
    }
    public function baominglist(Request $request,$tid) {

        $page = $request->input("page",1);
        $num = $request->input("num",100);
        $sql = " select * from tubuorder where tid=? and del=0 ";
        $res = DB::select($sql,[$tid]);
//        把两小时内没有付款的软删除
        for( $i=0;$i<count($res);$i++ ) {
            if($res[$i]->orderid == '0' && (time() - strtotime("+2 hours",strtotime($res[$i]->ordertime)) >=0) ) {
                $sql3 = " update tubuorder set del=1 where id=? ";
                DB::update($sql3,[$res[$i]->id]);
            }
        }
        $sql = " select tubuorder.*,userattr.uname,user.phone from tubuorder left join user on user.id=tubuorder.uid left join userattr on userattr.uid=tubuorder.uid where tid=? and del=0 order by tubuorder.id asc  ";
        $res = DB::select($sql,[$tid]);
        $count = DB::select("select count(*) as cnt from tubuorder where tid=? and del=0",[$tid]);
        return view("web.baominglist",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/v9",$page,$num),"count"=>$count[0]->cnt]);
    }

    public function my() {
        if( Session::get("uid") ) {
            return redirect("/user/".Session::get("uid"));
        }else{
            return redirect($_SERVER['HTTP_REFERER']);
        }

    }

    public function tububaoming($tid) {
        $sql = " select * from tubuhuodong where id=? limit 1 ";
        $res = DB::select($sql,[$tid]);
        if( count($res) == 1 ) {
            $youkes = array();
            if( Session::get("uid") ) {
                $sql = " select * from youkes where uid=? group by name order by id desc ";
                $youkes = DB::select($sql,[Session::get("uid")]);

//                查看有没有之前的订单信息
                $sql = " select * from tubuorder where uid=? order by id desc limit 1 ";
                $user = DB::select($sql,[Session::get("uid")]);
                if( count($user) == 1 ) {
                    $c_name = $user[0]->realname;
                    $c_mobile = $user[0]->mobile;
                }else{
                    $c_name = "";
                    $c_mobile = "";
                }

            }
            return view("web.tububaoming",["data"=>$res[0],"youkes"=>$youkes,"c_name"=>$c_name,"c_mobile"=>$c_mobile]);
        }else{
            return view("web.error",["content"=>"内容不存在"]);
        }
    }

    public function forgetpassword() {
        return view("web.forgetpassword");
    }

    public function tuiguang(Request $request) {
        $page = $request->input("page",1);
        $num = $request->input("num",10);
        $sql = " select realname,mobile,money,ordertime,youkes,uid,tubuorder.orderid,tixian from tubuorder left join payment on tubuorder.orderid=payment.orderid where proxy=? and tubuorder.orderid<>'0' order by tubuorder.id desc limit ?,?  ";
        $res = DB::select($sql,[Session::get('uid'),($page-1)*$num,$num]);

        $count = DB::select("select count(*) as cnt from tubuorder where proxy=? and orderid<>'0' ",[Session::get('uid')]);
        $sq = "select sum(money) as mon from tubuorder left join payment on tubuorder.orderid=payment.orderid where proxy=? and tixian=0 and tubuorder.orderid<>'0' ";
        $tixian = DB::select($sq,[Session::get('uid')]);
        return view('web.tuiguang',["list"=>$res,'tixian'=>sprintf("%.1f",(float)$tixian[0]->mon*0.1),"fenye"=>fenye($count[0]->cnt,"/tuiguang",$page,$num)]);
    }
    public function tunaer($uid){
        $sql = " select * from user where id=? and proxy=1 ";
        $res = DB::select($sql,[$uid]);
        if( count($res) ) {
            $sql = " select * from tubuhuodong where jiezhi>? and startday>? order by paixu desc,id desc limit 20 ";
            $res = DB::select($sql,[date("Y-m-d H:i:s"),date("Y-m-d H:i:s")]);
            return view('web.tunaer',["list"=>$res,"spreadid"=>$uid]);
        }else{
            return view('web.error');
        }

    }

    
}
