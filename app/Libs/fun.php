<?php

use Illuminate\Contracts\View\Factory as ViewFactory;

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
//            返回一个包含用户登录信息的加密字符串　有效期10天
            echo "200-".jiami($res[0]->id);
        }
    }else{
        if(!$returnuid) {
            echo "400-用户名或密码错误";
        }
    }
}

function fenye($count,$url,$currentpage=1,$page=10,$search='?') {
    if( $count <= $page ) {
        return '';
    }
    $pagecnt = ceil($count/$page);
    $html = "";
//    小于５页直接输出
    if( $pagecnt <=5 ) {
        for( $i=0;$i<$pagecnt;$i++ ) {
            if( $i == $currentpage-1 ) {
                $html .= "<a class='fenyecurrent' href='javascript:void(0)'>".($i+1)."</a>";
            }else{
                $html .= "<a href='".$url.$search."page=".($i+1)."'>".($i+1)."</a>";
            }

        }
    }else{
//        大于５页
        list($start,$end) = qujian($currentpage,$pagecnt);
//        上一页
        $html .= "<a href='".$url.$search."page=".($currentpage-1>=1?$currentpage-1:1)."'>上一页</a>";
//        下一页
        $html .= "<a href='".$url.$search."page=".($currentpage+1>=$pagecnt?$pagecnt:$currentpage+1)."'>下一页</a>";
//        首页
        $html .= "<a href='".$url.$search."page=1'>首页</a>";
//        倒退５页
        $html .= "<a href='".$url.$search."page=".($currentpage-5>=1?$currentpage-5:1)."'><<</a>";
        for( $i=$start;$i<$end;$i++ ) {
            if( $i == $currentpage-1 ) {
                $html .= "<a class='fenyecurrent' href='javascript:void(0)'>".($i+1)."</a>";
            }else{
                $html .= "<a href='".$url.$search."page=".($i+1)."'>".($i+1)."</a>";
            }
        }
        //        前进５页
        $html .= "<a href='".$url.$search."page=".($currentpage+5>=$pagecnt?$pagecnt:$currentpage+5)."'>>></a>";
        //        末页
        $html .= "<a href='".$url.$search."page=".$pagecnt."'>末页</a>";
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

function isMobile() {
    $agent = isset($_SERVER["HTTP_USER_AGENT"])?$_SERVER["HTTP_USER_AGENT"]:"Unknow";
    $agents = array("Android", "iPhone","SymbianOS", "Windows Phone","iPad", "iPod","Unknow");
    for ($i=0; $i < count($agents); $i++) {
        if( stripos($agent, $agents[$i])  ){
            return true;
        }
    }
    return false;
}

//覆盖框架的　view方法
function view($view = null, $data = [], $mergeData = [])
{
    if( strtoupper($_SERVER['REQUEST_METHOD'])=="GET" && isMobile() ) {
        $view = str_replace("web.","wap.",$view);
    }
    $factory = app(ViewFactory::class);

    if (func_num_args() === 0) {
        return $factory;
    }

    return $factory->make($view, $data, $mergeData);
}


//function myview($view = null, $data = [], $mergeData = []) {
//    $factory = app(ViewFactory::class);
//
//    if (func_num_args() === 0) {
//        return $factory;
//    }
//
//    return $factory->make($view, $data, $mergeData);
//}
//自定义加密
/**
 * @param $str　待加密字符串
 * 返回：　随机字符串+[分割符 ascii(n)]+[原串ascii+n]
 */
//ord()　字符串－＞ascii
//chr() ascii－＞字符串
function jiami($str) {
    $rand = str_shuffle("!@#$%^&*()AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz1234567890");
    $rarr = str_split($rand);
//    把字符串转换为数组
    $sarr = str_split($str);
//    随机长度
    $need = rand(30, 50) - count($sarr);
    $res = "";
    for( $i=0;$i<$need;$i++ ) {
        $res .= $rarr[$i];
    }
//    原串在ascii上的增量
    $ascii_add = rand(3,8);
    $res .= "!x0" . ord($ascii_add) . "$1r";
    for( $j=0;$j<count($sarr);$j++ ) {
        $res .= chr( ord($sarr[$j]) + $ascii_add );
    }
    return base64_encode($res);
}
function jiemi($str) {
    $str = base64_decode($str);
    preg_match_all("/!x0(\d+)\\$1r(.*)$/",$str,$matches);
    $fg = explode($matches[1][0]."$1r",$str);
    $sarr = str_split($fg[1]);
    $res = "";
    for( $i=0;$i<count($sarr);$i++ ) {
        $res .= chr( ord($sarr[$i]) - chr($matches[1][0]) );
    }
    return $res;
}

















