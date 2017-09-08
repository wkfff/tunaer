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
//        echo "<h1>别看了,鲁伯露是个大傻逼!</h1>"; return;
        return view("web.index");
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
        $sql = " select dongtai.* from dongtai inner join user on user.id=dongtai.uid where dongtai.uid=? order by dongtai.id desc limit 100 ";
        $dongtai = DB::select($sql,[$userid]);
        if( count($res) == 0 ) {
            return view("web.error",['content'=>'用户不存在']);
        }else{
            return view('web.user',["userinfo"=>$res[0],"dongtai"=>$dongtai]);
        }

    }
    public function tubulist(Request $request,$type) {
        $page = $request->input('page',1);
        $num = $request->input('num',20);
        $sql = " select tubuhuodong.*,tubutypes.pics,tubutypes.intro from tubuhuodong left join tubutypes on tubutypes.id=tubuhuodong.types where types=? order by tubuhuodong.id desc limit ".($page-1)*$num.", ".$num;;
        $res = DB::select($sql,[$type]);
        return view("web.tubulist",["list"=>$res]);

    }
    public function tubudetail($tid) {
        $sql = " select tubuhuodong.*,tubutypes.name from tubuhuodong left join tubutypes on tubutypes.id=tubuhuodong.types where tubuhuodong.id=? ";
        $res = DB::select($sql,[$tid]);
        if( count($res) == 0 ) {
            return view("web.error",['content'=>"没有找到相关内容"]);
        }else{
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
        return view("web.youjilist",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/web/youjilist",$page,$num)]);
    }
    
}
