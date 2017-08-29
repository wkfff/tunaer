<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
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
                $res = DB::update($sql,[$sex,$age,$intro,$mryst,$addr,$uname,Session::get('uid')]);
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
            $destinationPath = base_path() . "/public/data/images/";
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

    public function userhead($userid) {
        $sql = " select head from userattr where uid=? ";
        $res = DB::select($sql,[$userid]);
        if( count($res) >= 1 ) {
            header("Location:/data/images/".$res[0]->head);
        }else{
            header("Location:/images/default.jpg");
        }
    }
    
}
