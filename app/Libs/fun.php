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

function fenye($count,$url,$currentpage=1,$page=10) {
    $pagecnt = ceil($count/$page);
    $html = "";
//    小于５页直接输出
    if( $pagecnt <=5 ) {
        for( $i=0;$i<$pagecnt;$i++ ) {
            if( $i == $currentpage-1 ) {
                $html .= "<a class='fenyecurrent' href='".$url."?page=".($i+1)."'>".($i+1)."</a>";
            }else{
                $html .= "<a href='".$url."?page=".($i+1)."'>".($i+1)."</a>";
            }

        }
    }else{
//        大于５页
        list($start,$end) = qujian($currentpage,$pagecnt);
//        上一页
        $html .= "<a href='".$url."?page=".($currentpage-1>=1?$currentpage-1:1)."'>上一页</a>";
//        下一页
        $html .= "<a href='".$url."?page=".($currentpage+1>=$pagecnt?$pagecnt:$currentpage+1)."'>下一页</a>";
//        首页
        $html .= "<a href='".$url."?page=1'>首页</a>";
//        倒退５页
        $html .= "<a href='".$url."?page=".($currentpage-5>=1?$currentpage-5:1)."'><<</a>";
        for( $i=$start;$i<$end;$i++ ) {
            if( $i == $currentpage-1 ) {
                $html .= "<a class='fenyecurrent' href='".$url."?page=".($i+1)."'>".($i+1)."</a>";
            }else{
                $html .= "<a href='".$url."?page=".($i+1)."'>".($i+1)."</a>";
            }
        }
        //        前进５页
        $html .= "<a href='".$url."?page=".($currentpage+5>=$pagecnt?$pagecnt:$currentpage+5)."'>>></a>";
        //        末页
        $html .= "<a href='".$url."?page=".$pagecnt."'>末页</a>";
    }
    return "<div class='fenye' >".$html."</div>";
}

function qujian($current,$pagecnt) {

    $start = $current;
    $end = $current;
    for( $i=$current;$i<$pagecnt;$i++ ) {
        if( $end%5 == 0 ) {
            break;
        }
        $end++;
    }

    for( $i=$current;$i>=1;$i-- ) {
        $start--;
        if( $start%5 == 0 ) {
            break;
        }
    }
    return array($start,$end);
}





















