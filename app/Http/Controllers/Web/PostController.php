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
        $idcard = $request->input("idcard",'');
        $num = $request->input("num",'');
        $jihe = $request->input("jihe",'');
        $mark = $request->input("mark",'');
        $uid = Session::get('uid');

        $sqltmp = " select * from tubuorder where uid=? and tid=? ";
        $r = DB::select($sqltmp,[$uid,$tid]);
        if( count($r) > 0 ) {
            echo "400-你已经报名，请等待通知"; return ;
        }
        if( trim($tid) == '' ) {
            echo "400-活动不存在";
        }else{
            $sql = " insert into tubuorder (uid,tid,jihe,mobile,num,mark,idcard,realname) values (?,?,?,?,?,?,?,?) ";
            $res = DB::insert($sql,[$uid,$tid,$jihe,$mobile,$num,$mark,$idcard,$realname]);
            if( $res ) {
                echo "200-success";
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
                if( strstr($res[0]->head,"http") ) {
                    header("Location:".$res[0]->head);
                }else{
                    header("Location:/web/data/images/".$res[0]->head);
                }

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
        if( count($res) == 0 ) {
            echo "400-大赛不存在"; return;
        }
        if( $current < strtotime($res[0]->startday) || $current > strtotime($res[0]->endday)) {
            echo "400-请在指定时间段参加"; return;
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
        $num = $request->input("num",10);
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
            $sql = " select tubuhuodong.title,tubuhuodong.pictures,tubuhuodong.startday,tubuorder.* from tubuorder left join tubuhuodong on tubuhuodong.id=tubuorder.tid where uid=? order by tubuorder.id desc limit ?,? ";
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
                        login($phone,$passwd,true);
                    }else{
                        echo "400-注册失败";
                    }
                }else{
                    echo "400-验证码不正确";
                }
            }else{
//                绑定qq或者微信 openid
                if( $qqid != '' || $wxid != '' ) {
                    if( $qqid != '' ) {
                        $sql = " update user set qqid=?,passwd=? where id=? ";
                        $r = DB::update($sql,[$qqid,md5($passwd),$res[0]->id]);
                    }else{
                        $sql = " update user set wxid=?,passwd=? where id=? ";
                        $r = DB::update($sql,[$wxid,md5($passwd),$res[0]->id]);
                    }
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
        $sql = " select * from tubuhuodong order by id desc limit ?,? ";
        $tubus = DB::select($sql,[($page-1)*$num,$num]);
        echo json_encode($tubus);
    }
//    删除聊天
    public function delchat($userid) {
        $uid = Session::get("uid");
        $sql = " delete from chat where (fid=? and tid=?) or (fid=? and tid=?) ";
        $res = DB::delete($sql,[$userid,$uid,$uid,$userid]);
        if( $res ) {
            echo "200";
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
                $sql = " select * from tubucm where tid=? and uid=? and ctime like '%".date('Y-m-d')."%' ";
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
//    获取徒步评论
    public function gettubucms(Request $request) {
        $tid = $request->input('yid','');
        $page = $request->input("page",1);
        $num = $request->input("num",10);
        if( checknull($tid) ) {
            $sql = " select * from tubucm where tid=? order by id desc limit ?,? ";
            $tubucm = DB::select($sql,[$tid,($page-1)*$num,$num]);
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
            }else if( $type == "wx" ) {
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
}