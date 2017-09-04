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
            echo "200";
        }
    }

}