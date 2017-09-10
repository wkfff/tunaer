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
            $sql = " update `$table` set status=0 where id=? ";
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
    
}