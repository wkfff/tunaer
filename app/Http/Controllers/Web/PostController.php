<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PostController extends Controller{

//    随机推荐徒步活动
    public function huodongtuijian(Request $request) {
        $num = $request->input("num",4);
        $sql = " select * from tubuhuodong order by rand() limit ?";
        $res = DB::select($sql,[$num]);
        echo json_encode($res);
    }
//    活动报名
    public function baoming(Request $request) {
        $tid = $request->input("tid",'');
        $orderid = "123";
        if( $tid == '' ) {
            echo "400-活动不存在";
        }else{
            $uid = Session::get('uid');
            $sql = " insert into tubuorder (uid,tid,orderid) values (?,?,?) ";
            $res = DB::insert($sql,[$uid,$tid,$orderid]);
            if( $res ) {
                echo "200";
            }else{
                echo "400-报名失败，请联系客服";
            }
        }
        echo "400-支付接口未开通,功能暂不可用";
    }
    public function updateuserinfo(Request $request) {
        $uname = $request->input('uname');
        $sex = $request->input('sex');
        $age = $request->input('age');
        $intro = $request->input('intro');
        $mryst = $request->input('mryst');
        $addr = $request->input('addr');

        if( checknull($uname,$sex,$age,$intro,$mryst,$addr) ) {
            $sql = " select * from userattr where uid=? ";
            $res = DB::select($sql,[Session::get('uid')]);
            if( count($res) == 0 ) {
                $sql = " insert into userattr (uid,sex,age,intro,mryst,addr,uname) values (?,?,?,?,?,?,?) ";
                $res = DB::insert($sql,[Session::get('uid'),$sex,$age,$intro,$mryst,$addr,$uname]);
            }else{
                $sql = " update userattr set uname=?,sex=?,age=?,intro=?,mryst=?,addr=? where uid=?";
                $res = DB::update($sql,[$uname,$sex,$age,$intro,$mryst,$addr,Session::get('uid')]);
            }
            echo "200-修改成功";
        }else{
            echo "400-信息不完整";
        }
    }

    public function updatehead(Request $request){
        $uid = Session::get('uid');
        $file = $request->file('file',null);
        if ($file->isValid()) {
            $imgname = $uid."_".time() .".". $file->getClientOriginalExtension();
            $destinationPath = base_path() . "/public/web/data/images/";
            if( $file->move($destinationPath,$imgname) ) {
                $sql = " select * from userattr where uid=? ";
                $res = DB::select($sql,[$uid]);
                if( count($res) == 0 ) {
                    $sql = " insert into userattr (uid,head) values (?,?) ";
                    $res = DB::insert($sql,[$uid,$imgname]);
                }else {
                    $sql = " update userattr set head=? where uid=? ";
                    $res = DB::update($sql, [$imgname, $uid]);
                }
                echo "200-修改成功";
            }else{
                echo "400-修改失败";
            }
        }else{
            echo "400-修改失败";
        }
    }

    public function userhead($userid=null) {
        if( !$userid ) {
            header("Location:/web/images/default.gif"); return;
        }
        $sql = " select head from userattr where uid=? ";
        $res = DB::select($sql,[$userid]);
        if( count($res) >= 1 ) {
            if( trim($res[0]->head) == '' ) {
                header("Location:/web/images/default.gif");
            }else{
                header("Location:/web/data/images/".$res[0]->head);
            }

        }else{
            header("Location:/web/images/default.gif");
        }
    }

    public function fabudongtai(Request $request) {
        $uid = Session::get('uid');
        $comment = $request->input("content");
        $title = $request->input("title");
    }
    public function uploadimg(Request $request) {
        $file = $request->file('file');
        if ($file->isValid()) {
            $imgname = time() .".". $file->getClientOriginalExtension();
            $destinationPath = base_path() . "/public/web/data/images/";

            if( $file->move($destinationPath,$imgname) ) {
                // 返回图片名
                echo $imgname;
            }else{
                echo "400-操作失败";
            }
        }
    }
    public function fadongtai(Request $request) {
        $content = $request->input("content");
        $imgs = $request->input("imgs");
        $sql = " insert into dongtai (uid,content,imgs) values (?,?,?) ";
        $res = DB::insert($sql,[Session::get("uid"),$content,$imgs]);
        if( $res ) {
            echo "200";
        }else{
            echo "400-发布失败";
        }
    }
    public function dongtaicm(Request $request) {
        $did = $request->input("did");
        $content = $request->input("content");
        if( $content == "1" ) {
            $sql = " select * from dongtaicm where uid=? and did=? and content=1";
            if( DB::select($sql,[Session::get("uid"),$did]) ) {
                echo "400-已赞过了"; return;
            }
        }
        $sql = " insert into dongtaicm (uid,did,content) values (?,?,?) ";
        $res = DB::insert($sql,[Session::get("uid"),$did,$content]);
        if( $res ) {
            if( $content == "1" ) {
                @DB::table('dongtai')->where('id', $did)->increment('zancnt' ,1);
            }else{
                @DB::table('dongtai')->where('id', $did)->increment('cmcnt', 1);
            }
            echo "200";
        }else{
            echo "400-操作失败";
        }
    }
    public function dongtaicmlist(Request $request) {
        $page = $request->input("page",1);
        $num = $request->input("num",5);
        $did = $request->input("did");
        $sql = " select * from dongtaicm where content<>1 and did=? order by id desc limit ?,? ";
        $res = DB::select($sql,[$did,($page-1)*$num,$num]);
        echo json_encode($res);
    }
    public function fabuyouji(Request $request) {
        $content = $request->input("tuwen");
        $title = $request->input("title");
        $pic = $request->input("pic");
        $sql = " insert into youji (uid,title,tuwen,pic) values (?,?,?,?) ";
        $res = DB::insert($sql,[Session::get("uid"),$title,$content,$pic]);
        if( $res ) {
            echo "200";
        }else{
            echo "400-发布失败";
        }
    }
    public function canjiadasai(Request $request) {
        $did = $request->input("did","");
        $intro = $request->input("intro",'');
        $pic = $request->input("pic",'');
        if( $intro == '' || $pic == '' || $did == '' ) {
            echo "400-信息不完整"; return;
        }
//        检查重复参加
        $sql = " select * from works where did=? and uid=? ";
        $res = DB::select($sql,[$did,Session::get('uid')]);
        if(count($res) > 0 ) {
            echo "400-你已经参加过了"; return;
        }
//        检查当前时间是否允许参加大赛
        $current = time();
        $sql = " select * from dasai where id=? ";
        $res = DB::select($sql,[$did]);
        if( $current < strtotime($res[0]->startday) || $current > strtotime($res[0]->endday)) {
            echo "400-大赛不存在"; return;
        }

        $sql = " insert into works (uid,did,pics,intro) values (?,?,?,?) ";
        $res = DB::insert($sql,[Session::get('uid'),$did,$pic,$intro]);
        if( $res ) {
            echo "200";
        }else{
            echo "400-操作失败";
        }
    }
    public function toupiao(Request $request) {
        $wid = $request->input('wid',"no");
        if( $wid == 'no' ) {
            echo "400-操作无效"; return;
        }
        $uid = Session::get("uid");
        $sql = " select * from toupiao where uid=? and tday=? ";
        $res = DB::select($sql,[$uid,date("Y-m-d")]);
        if( count($res) >=3 ) {
            echo "400-你今日的投票已用完，请明天再试"; return;
        }
        $sql = " insert into toupiao (uid,wid,tday) values(?,?,?) ";
        $res = DB::insert($sql,[$uid,$wid,date("Y-m-d")]);
        if( $res ) {
            @DB::table("works")->where("id",$wid)->increment("depiao",1);
            echo "200";
        }else{
            echo "400-操作失败";
        }
    }
    public function uploadxiangce(Request $request) {
        $uid = Session::get('uid');
        $file = $request->file('file',null);
        if ($file->isValid()) {
            $imgname = $uid."_".time() .".". $file->getClientOriginalExtension();
            $destinationPath = base_path() . "/public/web/data/images/";
            if( $file->move($destinationPath,$imgname) ) {
                $sql = " insert into xiangce (uid,pic) values (?,?) ";
                $res = DB::insert($sql,[$uid,$imgname]);
                echo "200";
            }else{
                echo "400-上传失败";
            }
        }else{
            echo "400-上传失败";
        }
    }

    public function liuyan(Request $request) {
        $content = $request->input("content",'');
        $userid = $request->input("userid",'');
        if( checknull($content,$userid) ) {
            $sql = " insert into liuyan (fid,tid,content) values(?,?,?) ";
            $res = DB::insert($sql,[Session::get("uid"),$userid,$content]);
            if( $res ) {
                echo "200";
            }else{
                echo "400-操作失败";
            }
        }else{
            echo "400-无效操作";
        }
    }

    public function zhaohu(Request $request) {
        $user = $request->input("userid",'');
        if( $user == '' ) {
            echo  "400-无效操作"; return;
        }
        $sql = " select * from chat where fid=? and tid=? and type=2 and sdate=? ";
        $r = DB::select($sql,[Session::get('uid'),$user,date("Y-m-d")]);
        if( count($r) >= 1 ) {
            echo "400-今日已打招呼"; return;
        }
        $sql = " insert into chat (fid,tid,content,type,sdate) values(?,?,?,?,?) ";
        $res = DB::insert($sql,[Session::get('uid'),$user,0,2,date('Y-m-d')]);
        if( $res ) {
            echo "200";
        }else{
            echo "400-操作失败";
        }
    }

    public function sendchat(Request $request) {
        $userid = $request->input("userid",'');
        $content = $request->input("content",'');
        if( checknull($userid,$content) ) {
            $sql = " insert into chat (fid,tid,content,type,sdate) values(?,?,?,?,?) ";
            $res = DB::insert($sql,[Session::get('uid'),$userid,$content,1,date('Y-m-d')]);
            if( $res ) {
                echo "200";
            }else{
                echo "400-发送失败";
            }
        }else{
            echo "400-发送失败";
        }
    }

    public function getchathistory(Request $request) {
        $userid = $request->input("userid",'');
        $page = $request->input("page",1);
        $num = $request->input("num",10);
        $uid = Session::get("uid");
        if( $userid == '' ) {
            echo "400-无效操作"; return;
        }else{
            $sql = " select * from chat where (fid= ? and tid=?) or ( fid=? and tid=? ) order by id desc limit ?,? ";
            $res = DB::select($sql,[$userid,$uid,$uid,$userid,($page-1)*$num,$num]);
            echo json_encode($res);
        }
    }
//    获取聊天列表
    public function getchatlist(Request $request) {
        $userid = $request->input('userid','');
        $page = $request->input("page",1);
        $num = $request->input("num",8);
        if( checknull($userid) ) {
            $sql = " select * from userattr where uid in ( select tid as userid from chat where fid=? union select fid as userid from chat where tid=? group by userid ) order by id desc limit ?,? ";
            $res = DB::select($sql,[$userid,$userid,($page-1)*$num,$num]);
            echo json_encode($res);
        }
    }
//    获取相册
    public function getphotos(Request $request) {
        $userid = $request->input('userid','');
        $page = $request->input("page",1);
        $num = $request->input("num",8);
        if( checknull($userid) ) {
            $sql = " select * from xiangce where uid=? order by id desc limit ?,? ";
            $xiangce = DB::select($sql,[$userid,($page-1)*$num,$num]);
            echo json_encode($xiangce);
        }
    }
//    获取动态列表
    public function getdongtais(Request $request) {
        $userid = $request->input('userid','');
        $page = $request->input("page",1);
        $num = $request->input("num",5);
        if( checknull($userid) ) {
            $sql = " select dongtai.* from dongtai inner join user on user.id=dongtai.uid where dongtai.uid=? order by dongtai.id desc limit ?,? ";
            $dongtai = DB::select($sql,[$userid,($page-1)*$num,$num]);
            echo json_encode($dongtai);
        }
    }
    public function getshoporders(Request $request) {
        $userid = $request->input('userid','');
        $page = $request->input("page",1);
        $num = $request->input("num",5);
        if( checknull($userid) ) {
            $sql = " select shoporder.*,product.title,product.pictures,product.price from shoporder left join product on product.id=shoporder.shopid where shoporder.uid=? order by shoporder.id desc limit ?,? ";
            $shoporder = DB::select($sql,[$userid,($page-1)*$num,$num]);
            echo json_encode($shoporder);
        }
    }

    //    获取留言列表
    public function getliuyans(Request $request) {
        $userid = $request->input('userid','');
        $page = $request->input("page",1);
        $num = $request->input("num",5);
        if( checknull($userid) ) {
            $sql = " select * from liuyan where tid=? order by id desc limit ?,? ";
            $liuyan = DB::select($sql,[$userid,($page-1)*$num,$num]);
            echo json_encode($liuyan);
        }
    }

    //    获取留言列表
    public function getyoujis(Request $request) {
        $userid = $request->input('userid','');
        $page = $request->input("page",1);
        $num = $request->input("num",5);
        if( checknull($userid) ) {
            $sql = " select * from youji where uid=? order by id desc limit ?,? ";
            $youji = DB::select($sql,[$userid,($page-1)*$num,$num]);
            echo json_encode($youji);
        }
    }
//    评论游记
    public function youjicm(Request $request) {
        $content = $request->input("content",'');
        $yid = $request->input("yid",'');
        $type = $request->input("type",1);
        if( checknull($content,$yid) ) {
//            检查重复赞
            if( $type == 2 ) {
                $sql = " select * from youjicm where yid=? and uid=? and ltime like '%".date('Y-m-d')."%' ";
                $r = DB::select($sql,[$yid,Session::get('uid')]);
                if(count($r) > 0) {
                    echo "400-今日已赞"; return ;
                }
            }
            $sql = " insert into youjicm (uid,yid,content,type) values(?,?,?,?) ";
            $res = DB::insert($sql,[Session::get('uid'),$yid,$content,$type]);
            if( $res ) {
                if( $type == 1 ) {
                    @DB::table("youji")->where("id",$yid)->increment("cmcnt",1);
                }else{
                    @DB::table("youji")->where("id",$yid)->increment("zancnt",1);
                }
                echo "200";
            }else{
                echo "400-操作失败";
            }
        }
    }

    //    获取游记留言列表
    public function getyoujicms(Request $request) {
        $yid = $request->input('yid','');
        $page = $request->input("page",1);
        $num = $request->input("num",2);
        if( checknull($yid) ) {
            $sql = " select * from youjicm where yid=? and type=1 order by id desc limit ?,? ";
            $youji = DB::select($sql,[$yid,($page-1)*$num,$num]);
            echo json_encode($youji);
        }
    }
//    统一下单
    public function xiadan(Request $request) {
        $orders = $request->input('order');
        $phone = $request->input('phone');
        $liuyan = $request->input('liuyan');
        $addr = $request->input('addr');
        $orderid = "123";
        $uid = Session::get('uid');
        $success = 0;
//        开启事务
        DB::beginTransaction();
        for( $i=0;$i<count($orders);$i++ ) {
            $sql = " insert into shoporder (uid,shopid,num,color,chicun,phone,addr,liuyan,orderid) values (?,?,?,?,?,?,?,?,?) ";
            $res = DB::insert($sql,[$uid,$orders[$i]['shopid'],$orders[$i]['num'],$orders[$i]['color'],$orders[$i]['chicun'],$phone,$addr,$liuyan,$orderid]);
            if(!$res) {
                DB::rollback();//事务回滚
                echo "400-下单失败，请重试或联系客服"; return ;
            }else{
                $success++;
            }
        }
//        提交事务
        DB::commit();
        if( $success != count($orders) ) {
            echo "400-部分订单未成功，请核对并联系客服";
        }else{
            echo "200";
        }
    }

    //    获取留言列表
    public function gettubuorders(Request $request) {
        $userid = $request->input('userid','');
        $page = $request->input("page",1);
        $num = $request->input("num",5);
        if( checknull($userid) ) {
            $sql = " select tubuhuodong.*,tubuorder.ordertime from tubuorder left join tubuhuodong on tubuhuodong.id=tubuorder.tid where uid=? order by tubuorder.id desc limit ?,? ";
            $orders = DB::select($sql,[$userid,($page-1)*$num,$num]);
            echo json_encode($orders);
        }
    }

    // 注册
    public function register(Request $request) {

        $phone = $request->input('phone');
        $passwd = $request->input('passwd');
        $code = $request->input('code');
        if( !checknull($phone,$passwd,$code) ) {
            echo "400-请填写完整信息";
        }else{
            $sql = " select * from user where phone=? ";
            $res = DB::select($sql,[$phone]);
            if( count($res) == 0 ) {
                if( Cache::get('code-'.$phone) == $code ) {
                    $sql = " insert into user (phone,passwd,regip) values (?,?,?) ";
                    $res = DB::insert($sql,[$phone,md5($passwd),$_SERVER['REMOTE_ADDR']]);
                    if( $res ) {
                        echo "200-注册成功";
                        Session::forget('uid');
                        // 直接登录
                        login($phone,$passwd,true);
                    }else{
                        echo "400-注册失败";
                    }
                }else{
                    echo "400-验证码不正确";
                }
            }else{
                echo "400-手机号码已经注册过了，你可以直接登录";
            }
        }
    }
    // 登录
    public function login(Request $request) {
        $phone = $request->input('phone');
        $passwd = $request->input('passwd');
        $verifycode = $request->input('verifycode');
        if( !checknull($phone,$passwd,$verifycode) ) {
            echo "400-请填写完整信息";
        }else{
            if( $verifycode != Session::get('verifycode') ) {
                echo "400-验证码错误";
            }else{
                login($phone,$passwd,false);
            }

        }
    }

    // 发送手机验证码
    public function sendcode(Request $request ) {
        $phone = $request->input('phone');
        if( !preg_match("/^1[34578]{1}\d{9}$/",$phone) ){
            echo "400-手机格式错误";
            return false;
        }
        // $code = rand(123456,999999);
        $code = "123456";
        Cache::put('code-'.$phone, $code, 10);
        echo "200-发送成功";
    }
    // 生成图形验证码
    public function verifycode()
    {
        $x = new \App\Libs\verifycode();
        Session::put("verifycode",$x->getcode());
        $x->outimg();
    }

}