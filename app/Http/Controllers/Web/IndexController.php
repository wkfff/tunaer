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
        $sql = " select userattr.* from user left join userattr on user.id=userattr.uid where user.status=1 and user.id=? ";
        $res = DB::select($sql,[$userid]);
        if( count($res) == 0 ) {
            return view("web.error",['content'=>'用户不存在']);
        }else{
            return view('web.user',["userinfo"=>$res[0]]);
        }

    }
    public function tubulist(Request $request,$type) {
        $page = $request->input('page',1);
        $num = $request->input('num',20);
        $sql = " select * from tubuhuodong left join tubutypes on tubutypes.id=tubuhuodong.types where types=? order by tubuhuodong.id desc limit ".($page-1)*$num.", ".$num;;
        $res = DB::select($sql,[$type]);
        return view("web.tubulist",["list"=>$res]);

    }
    public function tubudetail($tid) {
        $sql = " select * from tubuhuodong where id=? ";
        $res = DB::select($sql,[$tid]);
        if( count($res) == 0 ) {
            return view("web.error",['content'=>"没有找到相关内容"]);
        }else{
            return view("web.tubudetail",['detail'=>$res[0]]);
        }
    }
    
}
