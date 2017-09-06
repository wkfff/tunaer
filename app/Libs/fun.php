<?php

function checknull(...$args)
{
    foreach( $args as $arg ){
        if( !$arg || trim($arg) == '' ) {
            return false;
        }
    }
    return true;
}

function login($phone,$passwd,$returnuid=false) {
    $sql = " select user.*,userattr.uname from user left join userattr on user.id=userattr.uid where phone=? and passwd=?  ";
    $res = DB::select($sql,[$phone,md5($passwd)]);
    if( count($res) >= 1 ) {
        if( $res[0]->status == 0 ) {
            echo "400-账户不可用"; return;
        }
        if( !$res[0]->uname ) {
            $res[0]->uname = '请完善资料';
        }
        Session::put('uid', $res[0]->id);
        Session::put('uname', $res[0]->uname);
        if(!$returnuid) {
            echo "200-登录成功";
        }
    }else{
        if(!$returnuid) {
            echo "400-用户名或密码错误";
        }
    }
}