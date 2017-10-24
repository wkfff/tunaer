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
            echo "200";
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
            echo "200";
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
            echo "200";
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
            echo "200";
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
            echo "200";
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
            echo "200";
        }else{
            echo "400-操作失败";
        }
    }
    public function fabudasai(Request $request) {
        $title = $request->input("title");
        $tuwen = $request->input("tuwen");
        $startday = $request->input("startday");
        $endday = $request->input("endday");
        $pic = $request->input("pic");
        $id = $request->input("id","no");
        if( $id == 'no' ) {
            $sql = " insert into dasai (endday,startday,title,tuwen,pic) values(?,?,?,?,?) ";
            $res = DB::insert($sql,[$endday,$startday,$title,$tuwen,$pic]);
        }else{
            $sql = " update dasai set title=?,tuwen=?,pic=?,endday=?,startday=? where id=? ";
            $res = DB::update($sql,[$title,$tuwen,$pic,$endday,$startday,$id]);
        }
        if( $res ) {
            echo "200";
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
            echo "200";
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
                echo "200";
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
                echo "200";
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
                echo "200";
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
                echo "200";
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
            echo "200";
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
            echo "200";
        }else{
            echo "400-操作失败";
        }
    }
}