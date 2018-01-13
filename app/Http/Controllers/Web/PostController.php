<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
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
        $realname = $request->input("realname",'');
        $mobile = $request->input("mobile",'');
//        $idcard = $request->input("idcard",'');
        $youkes = $request->input("youkes",'');
        $num = $request->input("num",'');
        $jihe = $request->input("jihe",'');
        $proxy = $request->input("proxy",'0');
        $mark = $request->input("mark",'') == ''?"无":$request->input("mark",'');
        $uid = Session::get('uid');

        $sql1 = " select sum(num) as baomingnum,need,jiezhi from tubuorder inner join tubuhuodong on tubuhuodong.id=tubuorder.tid where tid=? and orderid<>'0' ";
        $res1 = DB::select($sql1,[$tid]);
        if( date("Y-m-d H:i:s") > $res1[0]->jiezhi ) {
            echo "400-报名已截止"; return ;
        }
        if( ( $res1[0]->baomingnum + $num ) >$res1[0]->need ) {
            echo "400-报名人数已满"; return ;
        }
//        echo "400-测试";die;
//        $sqltmp = " select * from tubuorder where uid=? and tid=? and del=0 ";
//        $r = DB::select($sqltmp,[$uid,$tid]);
//        if( count($r) > 0 ) {
//            echo "400-你已经报名，请等待通知"; return ;
//        }
        if( trim($tid) == '' ) {
            echo "400-活动不存在";
        }else{
            $sql = " insert into tubuorder (uid,tid,jihe,mobile,num,mark,youkes,realname,proxy) values (?,?,?,?,?,?,?,?,?) ";
            $res = DB::insert($sql,[$uid,$tid,$jihe,$mobile,$num,$mark,$youkes,$realname,$proxy]);
            if( $res ) {
//                添加报名人数
//                @DB::table('tubuhuodong')->where('id', $tid)->increment('baoming' ,$num);
                echo "200-success";
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
    }
    public function updateuserinfo(Request $request) {
        $uname = $request->input('uname');
        $sex = $request->input('sex');
        $age = $request->input('age');
        $intro = $request->input('intro');
        $mryst = $request->input('mryst');
        $addr = $request->input('addr');
//        if( checknull($uname,$sex,$age,$intro,$mryst,$addr) ) {
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
//        }else{
//            echo "400-信息不完整";
//        }
    }

    public function updatehead(Request $request){
        $uid = Session::get('uid');
        $file = $request->file('file',null);
        if ($file->isValid()) {
            $imgname = $uid."_".time() .".". $file->getClientOriginalExtension();
            $destinationPath = base_path() . "/public/web/data/images/";
            if( $file->move($destinationPath,$imgname) ) {
                @img850($destinationPath.$imgname,400);
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
            header("Location:/web/images/defaultgirl.png"); return;
        }
        $sql = " select head,sex from userattr where uid=? ";
        $res = DB::select($sql,[$userid]);
        if( count($res) > 0 ) {
            if( !trim($res[0]->head) ) {
                header("Location:/web/images/".($res[0]->sex=="男" ? "defaultboy.png":"defaultgirl.png"));
            }else{
                if( strstr($res[0]->head,"http") ) {
                    if(strlen($res[0]->head) <= 25) {
                        header("Location:/web/images/".($res[0]->sex=="男" ? "defaultboy.png":"defaultgirl.png"));
                    }else{
                        header("Location:".$res[0]->head);
                    }
                }else{
                    header("Location:/web/data/images/".$res[0]->head);
                }
            }
        }else{
            header("Location:/web/images/defaultgirl.png");
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
                img850($destinationPath.$imgname);
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
            echo "200-success";
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
            echo "200-success";
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
            echo "200-success";
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
        if( count($res) == 0 ) {
            echo "400-大赛不存在"; return;
        }
        if( $current < strtotime($res[0]->startday) ) {
            echo "400-活动准备中，请关注开始时间";return ;
        }
        if( $current > strtotime($res[0]->endday)) {
            echo "400-活动已经结束啦"; return;
        }

        $sql = " insert into works (uid,did,pics,intro) values (?,?,?,?) ";
        $res = DB::insert($sql,[Session::get('uid'),$did,$pic,$intro]);
        if( $res ) {
            echo "200-success";
        }else{
            echo "400-操作失败";
        }
    }
    public function toupiao(Request $request) {
        $wid = $request->input('wid',"no");
        if( $wid == 'no' ) {
            echo "400-操作无效"; return;
        }
//        判断投票是否开始 或　活动是否结束
        $sql = " select dasai.startday,dasai.uploadend,dasai.endday from works inner join dasai on works.did=dasai.id where works.id=? ";
        $res = DB::select($sql,[$wid]);
        if( count($res) ) {
            if( time() - strtotime($res[0]->endday) > 0 ) {
                echo "400-活动已经结束啦"; return ;
            }
            if( time() - strtotime($res[0]->startday) - $res[0]->uploadend*86400 < 0 ) {
                echo "400-前".$res[0]->uploadend."天只能上传作品，不许投票";
                return ;
            }
        }else{
            echo "400-操作异常";
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
            echo "200-success";
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
                echo "200-success";
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
                echo "200-success";
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
            echo "200-success";
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
                echo "200-success";
            }else{
                echo "400-发送失败";
            }
        }else{
            echo "400-发送失败";
        }
    }
//查看历史消息
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
            $sql2 = " update chat set isread=0 where  (fid= ? and tid=?) or ( fid=? and tid=? )  ";
            @DB::update($sql2,[$userid,$uid,$uid,$userid]);
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
                echo "200-success";
            }else{
                echo "400-操作失败";
            }
        }
    }

    //    获取游记留言列表
    public function getyoujicms(Request $request) {
        $yid = $request->input('yid','');
        $page = $request->input("page",1);
        $num = $request->input("num",10);
        if( checknull($yid) ) {
//            $sql = " select * from youjicm where yid=? and type=1 order by id desc limit ?,? ";
//            $youji = DB::select($sql,[$yid,($page-1)*$num,$num]);
//            echo json_encode($youji);
            $sql = " select * from youjicm where yid=? and pid=0 and type=1 order by id desc limit ?,? ";
            $youjicm = DB::select($sql,[$yid,($page-1)*$num,$num]);
            if( count($youjicm) == 0 ) {
                echo json_encode(array()); return;
            }
            $youjicmids = array();
            for($i=0;$i<count($youjicm);$i++) {
                array_push($youjicmids,$youjicm[$i]->id);
                $youjicm[$i]->sub = array();
            }
            $sql = " select * from youjicm where yid=? and pid in (".implode(',',$youjicmids).") order by id desc limit 200 ";
            $subcm = DB::select($sql,[$yid]);
            if( count($subcm) ) {
                foreach($subcm as $key=>$val) {
                    for($i=0;$i<count($youjicm);$i++) {
                        if( $youjicm[$i]->id == $val->pid ) {
                            array_push($youjicm[$i]->sub,$val);
                        }
                    }
                }
            }
            echo json_encode($youjicm);
        }
    }
//    统一下单
    public function xiadan(Request $request) {
        $orders = $request->input('order');
        $phone = $request->input('phone');
        $liuyan = $request->input('liuyan');
        $addr = $request->input('addr');
//        $orderid = "123";
        $uid = Session::get('uid');
        $success = 0;
//        开启事务
        DB::beginTransaction();
        for( $i=0;$i<count($orders);$i++ ) {
            $sql = " insert into shoporder (uid,shopid,num,color,chicun,phone,addr,liuyan) values (?,?,?,?,?,?,?,?) ";
            $res = DB::insert($sql,[$uid,$orders[$i]['shopid'],$orders[$i]['num'],$orders[$i]['color'],$orders[$i]['chicun'],$phone,$addr,$liuyan]);
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
            echo "200-success";
        }
    }

    //    获取留言列表
    public function gettubuorders(Request $request) {
        $sql = " select * from tubuorder where  del=0 ";
        $res = DB::select($sql);
        for( $i=0;$i<count($res);$i++ ) {
            if($res[$i]->orderid == '0' && (time() - strtotime("+2 hours",strtotime($res[$i]->ordertime)) >=0) ) {
                $sql3 = " update tubuorder set del=1 where id=? ";
                DB::update($sql3,[$res[$i]->id]);
            }
        }
        $userid = $request->input('userid','');
        $page = $request->input("page",1);
        $num = $request->input("num",5);
        if( checknull($userid) ) {
            $sql = " select tubuhuodong.title,tubuhuodong.pictures,tubuhuodong.startday,tubuhuodong.price,tubuorder.* from tubuorder left join tubuhuodong on tubuhuodong.id=tubuorder.tid where uid=? and del=0 order by tubuorder.id desc limit ?,? ";
            $orders = DB::select($sql,[$userid,($page-1)*$num,$num]);
            echo json_encode($orders);
        }
    }

    // 注册
    public function register(Request $request) {

        $phone = $request->input('phone');
        $passwd = $request->input('passwd');
        $code = $request->input('code');
        $qqid = $request->input('qqid','');
        $wxid = $request->input('wxid','');
        if( !checknull($phone,$passwd,$code) ) {
            echo "400-请填写完整信息";
        }else{
            if( Cache::get('code-'.$phone) != $code ) {
                echo "400-验证码不正确"; return;
            }
            $sql = " select user.*,userattr.uname from user left join userattr on user.id=userattr.uid where phone=? ";
            $res = DB::select($sql,[$phone]);
            if( count($res) == 0 ) {
                if( Cache::get('code-'.$phone) == $code ) {
                    $sql = " insert into user (phone,passwd,regip,qqid,wxid) values (?,?,?,?,?) ";
                    $res = DB::insert($sql,[$phone,md5($passwd),$_SERVER['REMOTE_ADDR'],$qqid,$wxid]);
                    if( $res ) {
                        $request->session()->flush();
                        // 直接登录
                        login($phone,$passwd);
                    }else{
                        echo "400-注册失败";
                    }
                }else{
                    echo "400-验证码不正确";
                }
            }else{
//                绑定qq或者微信 openid
                if( $qqid != '' || $wxid != '' ) {
                    $sql = " update user set wxid=?,passwd=?,qqid=? where id=? ";
                    $r = DB::update($sql,[$wxid,md5($passwd),$qqid,$res[0]->id]);
//                    if( $qqid != '' ) {
//                        $sql = " update user set qqid=?,passwd=? where id=? ";
//                        $r = DB::update($sql,[$qqid,md5($passwd),$res[0]->id]);
//                    }else{
//                        $sql = " update user set wxid=?,passwd=? where id=? ";
//                        $r = DB::update($sql,[$wxid,md5($passwd),$res[0]->id]);
//                    }
                    if( $r ) {
                        Session::put('uid', $res[0]->id);
                        Session::put('uname', $res[0]->uname);
                    }
                    echo "200-".jiami($res[0]->id);

                }else{
                    echo "400-手机号码已经注册过了，你可以直接登录";
                }

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
//    每一小时每一个ip最多发送5次验证码
        $csql = " select * from verifycode where ip=? and stime like '%".date("Y-m-d H")."%' ";
        $r = DB::select($csql,[$_SERVER['REMOTE_ADDR']]);
        if( count($r) >= 5 ) {
            echo "400-发送频繁，请稍后再试";
        }
        require_once app_path().'/Libs/aliyunsms/api_demo/SmsDemo.php';
        $demo = new \SmsDemo(
            "LTAICyYaKmLyh9sj",
            "fh7VDi4xBUIQPY4H13eAfVx88kfwaP"
        );
        $code = rand(123456,999999);
        $response = $demo->sendSms(
            "徒哪儿", // 短信签名
            "SMS_100220027", // 短信模板编号
            $phone, // 短信接收者
            Array(  // 短信模板中字段的值
                "code"=>$code
            ),"0"
        );
        if( strtoupper($response->Code) == "OK" ) {
            Cache::put('code-'.$phone, $code, 10);
//            记录到数据库
            $isql = " insert into verifycode (phone,ip,code) values (?,?,?) ";
            $r = DB::insert($isql,[$phone,$_SERVER['REMOTE_ADDR'],$code]);
            echo "200-发送成功";
        }else{
            echo "200-操作失败．请联系在线客服";
        }
    }
    // 生成图形验证码
    public function verifycode()
    {
        $x = new \App\Libs\verifycode();
        Session::put("verifycode",$x->getcode());
        $x->outimg();
    }
    //    获取留言列表
    public function recenttubu(Request $request) {

        $page = $request->input("page",1);
        $num = $request->input("num",10);
        $sql = " select * from tubuhuodong where visible=1 order by paixu desc,id desc limit ?,? ";
        $tubus = DB::select($sql,[($page-1)*$num,$num]);
        echo json_encode($tubus);
    }
//    删除聊天
    public function delchat($userid) {
        $uid = Session::get("uid");
        $sql = " delete from chat where (fid=? and tid=?) or (fid=? and tid=?) ";
        $res = DB::delete($sql,[$userid,$uid,$uid,$userid]);
        if( $res ) {
            echo "200-success";
        }else{
            echo "400-操作失败";
        }
    }
//徒步评论
    public function tubucm(Request $request) {
        $content = $request->input("content",'');
        $tid = $request->input("tid",'');
        $type = $request->input("type",1);
        if( checknull($content,$tid) ) {
//            检查重复赞
            if( $type == 2 ) {
                $sql = " select * from tubucm where tid=? and uid=? and type=2 and ctime like '%".date('Y-m-d')."%' ";
                $r = DB::select($sql,[$tid,Session::get('uid')]);
                if(count($r) > 0) {
                    echo "400-今日已赞"; return ;
                }
            }
            $sql = " insert into tubucm (uid,tid,content,type) values(?,?,?,?) ";
            $res = DB::insert($sql,[Session::get('uid'),$tid,$content,$type]);
            if( $res ) {
                if( $type == 1 ) {
                    @DB::table("tubuhuodong")->where("id",$tid)->increment("cmcnt",1);
                }else{
                    @DB::table("tubuhuodong")->where("id",$tid)->increment("zancnt",1);
                }
                echo "200-success";
            }else{
                echo "400-操作失败";
            }
        }
    }
//    回复游记评论
    public function youjisubcomment(Request $request) {
        $yid = $request->input('yid');
        $pid = $request->input('pid');
        $content = $request->input('content');
        $sql = " insert into youjicm (uid,yid,content,pid) values(?,?,?,?) ";
        $res = DB::insert($sql,[Session::get('uid'),$yid,$content,$pid]);
        if( $res ) {
            echo "200-评论成功";
        }else{
            echo "400-评论失败";
        }
    }
//    回复徒步评论
    public function tubusubcomment(Request $request) {
        $tid = $request->input('tid');
        $pid = $request->input('pid');
        $content = $request->input('content');
        $sql = " insert into tubucm (uid,tid,content,pid) values(?,?,?,?) ";
        $res = DB::insert($sql,[Session::get('uid'),$tid,$content,$pid]);
        if( $res ) {
            echo "200-评论成功";
        }else{
            echo "400-评论失败";
        }
    }
//    获取徒步评论
    public function gettubucms(Request $request) {
        $tid = $request->input('yid','');
        $page = $request->input("page",1);
        $num = $request->input("num",10);
        if( checknull($tid) ) {
            $sql = " select * from tubucm where tid=? and pid=0 and type=1 order by id desc limit ?,? ";
            $tubucm = DB::select($sql,[$tid,($page-1)*$num,$num]);
            if( count($tubucm) == 0 ) {
                echo json_encode(array()); return;
            }
            $tubucmids = array();
            for($i=0;$i<count($tubucm);$i++) {
                array_push($tubucmids,$tubucm[$i]->id);
                $tubucm[$i]->sub = array();
            }
            $sql = " select * from tubucm where tid=? and pid in (".implode(',',$tubucmids).") order by id desc limit 200 ";
            $subcm = DB::select($sql,[$tid]);
            if( count($subcm) ) {
                foreach($subcm as $key=>$val) {
                    for($i=0;$i<count($tubucm);$i++) {
                        if( $tubucm[$i]->id == $val->pid ) {
                            array_push($tubucm[$i]->sub,$val);
                        }
                    }
                }
            }
            echo json_encode($tubucm);
        }
    }
//    第三方登录
    public function otherlogin(Request $request) {
        $openid = $request->input("openid",false);
        $type = $request->input("type",false);
        if( checknull($openid,$type) ) {
            if( $type == "qq" ) {
                $sql = " select user.id,userattr.uname from user left join userattr on user.id=userattr.uid where qqid=? ";
            }else if( $type == "weixin" ) {
                $sql = " select user.id,userattr.uname from user left join userattr on user.id=userattr.uid where wxid=? ";
            }else{
                echo "400-认证失败";return;
            }
            $res = DB::select($sql,[$openid]);
            if( count($res) ) {
                Session::put('uid', $res[0]->id);
                Session::put('uname', $res[0]->uname);
                echo "200-".jiami($res[0]->id);
            }else{
                echo "400-请绑定手机号";
            }

        }
    }
//    初始化用户信息
    public function inituserinfo(Request $request) {
        $head = $request->input("head","");
        $uname = $request->input("uname","");
        $sex = $request->input("sex","");
        $age = $request->input("age","");
        $addr = $request->input("addr","");

        $sql = " select * from userattr where uid=? ";
        $res = DB::select($sql,[Session::get('uid')]);
        if( count($res) == 0 ) {
            $sql = " insert into userattr (uid,sex,age,head,addr,uname) values (?,?,?,?,?,?) ";
            $res = DB::insert($sql,[Session::get('uid'),$sex,$age,$head,$addr,$uname]);
        }else{
            $sql = " update userattr set uname=?,sex=?,age=?,head=?,addr=? where uid=?";
            $res = DB::update($sql,[$uname,$sex,$age,$head,$addr,Session::get('uid')]);
        }
        echo "200-success";
    }
//    使用login_token加密字符串登录
    public function tokenlogin(Request $request) {
        $token = $request->input("token",false);
        if( $token ) {
            $uid = jiemi($token);
            $sql = " select user.*,userattr.uname from user left join userattr on user.id=userattr.uid where user.id=?  ";
            $res = DB::select($sql,[$uid]);
            if( count($res) >= 1 ) {
                if( $res[0]->status == 0 ) {
                    echo "400-账户不可用"; return;
                }
                if( !$res[0]->uname ) {
                    $res[0]->uname = '请完善资料';
                }
                Session::put('uid', $res[0]->id);
                Session::put('uname', $res[0]->uname);
                echo "200-success";
            }else{
                echo "400-...";
            }
        }else{
            echo "400-...";
        }
    }
    public function getlastestorderinfo() {
        $uid = Session::get('uid');
        $sql = " select * from tubuorder where uid=? order by id desc limit 1 ";
        $res = DB::select($sql,[$uid]);
        echo json_encode($res);
    }

    public function createpay(Request $request) {
        $orderid = $request->input("orderid",'');
        $type = $request->input("type",'');
        $way = $request->input("way",'');
        $money = 0;
        if( checknull($orderid,$type,$way) ) {
            if( $type == "tubu" ) {
                $sql = " select tubuorder.*,tubuhuodong.price from tubuorder inner join tubuhuodong on tubuorder.tid=tubuhuodong.id where tubuorder.id=? ";
                $res = DB::select($sql,[$orderid]);
                if( count($res) == 1 ) {
                    $money = $res[0]->price;
                }else{
                    echo "400-支付异常";
                    return false;
                }
            }else{
                $sql = " select shoporder.*,product.price from shoporder inner join shoporder.shopid=product.id where shoporder.id=? ";
                $res = DB::select($sql,[$orderid]);
                if( count($res) == 1 ) {
                    $money = $res[0]->price;
                }else{
                    echo "400-支付异常";
                    return false;
                }
            }
            switch($way) {
                case "wxpay_saoma":
                    echo wxpay_saoma($orderid,$money,$type);
                    break;
            }
        }
    }

    public function changepasswd(Request $request) {
        $mobile = $request->input("mobile");
        $vcode = $request->input("vcode");
        $newpasswd = $request->input("newpasswd");
        if( Cache::get('code-'.$mobile) == $vcode ) {
            $sql = " select * from user where phone=? ";
            $res = DB::select($sql,[$mobile]);
            if( count($res) == 1 ) {
                $sql = " update user set passwd=? where phone=?  ";
                $res = DB::update($sql,[md5($newpasswd),$mobile]);
                echo "200-修改成功"; return ;
            }else{
                echo "400-该手机号码没有注册"; return ;
            }
        }else{
            echo "400-验证码错误";
        }
    }

    //http://www.ihuyi.com 短信接口
//    public static function bmtongzhi($mobile,$num,$content) {
//        $content = "您已经预订".$num."张，徒哪儿11-18 途步线路，已付59.00元。请您提前到达集合地点1：西南财大对面加油站旁（8.30集合）。请注意遵守时间，过时不候。对接人：徒哪儿户外俱乐部18000548612。欢迎加入此次客户QQ群(群号订单中查看)，分车及详细信息可以同时在订单中和群内公告查看。";
//        $url="http://106.ihuyi.com/webservice/sms.php?method=Submit";
//        $curlPost = array ("account" => "bob","password" => "12345","mobile"=>$mobile,"content"=>$content,"time"=>time(),"format"=>"js");
//        $curl = curl_init();
//        curl_setopt($curl, CURLOPT_URL, $url);
//        curl_setopt($curl, CURLOPT_HEADER, false);
//        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($curl, CURLOPT_NOBODY, true);
//        curl_setopt($curl, CURLOPT_POST, true);
//        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
//        $return_str = curl_exec($curl);
//        curl_close($curl);
//    }

    public function tixian(Request $request){
        $phone = $request->input('phone');
        $sql = " select * from tixian where uid=? and done=0 ";
        $r =  DB::select($sql,[Session::get('uid')]);
        if( count($r) ) {
            echo "400-请耐心等待处理..."; return;
        }
        $sq = "select sum(money) as mon from tubuorder left join payment on tubuorder.orderid=payment.orderid where proxy=? and tixian=0 and tubuorder.orderid<>'0' ";
        $tixian = DB::select($sq,[Session::get('uid')]);
        $sql = " insert into tixian (uid,mobile,money) values (?,?,?) ";
        $res = DB::insert($sql,[Session::get('uid'),$phone,(int)($tixian[0]->mon*0.1)]);
        if( $res ) {
            echo "200-申请成功，请耐心等待";
        }else{
            echo "400-申请失败，请联系管理员";
        }
    }
    public function deldata(Request $request) {

        $table = $request->input("table","none");
        $id = $request->input("id","0");
        if( $table == 'none' || $id == "0") {
            echo "400-操作失败";
        }else{
            $sql = " delete from `$table` where id=? and uid=? ";
            $res = DB::delete($sql,[$id,Session::get('uid')]);
            echo "200-success";
        }
    }

}