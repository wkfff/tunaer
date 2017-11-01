<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use League\Flysystem\Exception;
use PHPExcel;
use PHPExcel_IOFactory;

class IndexController extends Controller{

    public function index() {

        return view('admin.index');
    }
    public function login() {
        Session::forget('adminflag');
        return view('admin.login');
    }
//    登录
    public function dologin(Request $request) {
        $aname = $request->input("uname");
        $passwd = $request->input("passwd");
        if( !checknull($aname,$passwd) ) {
            echo "400-信息不完整";return ;
        }
        $sql = " select * from admin where aname=? and passwd=? ";
        $res = DB::select($sql,[$aname,md5($passwd)]);
        if( count($res) == 0 ) {
            echo "400-用户名或密码错误";return ;
        }
        if( $res[0]->status == 0 ) {
            echo "400-帐号已被冻结";return ;
        }
        Session::put("aname",$res[0]->aname);
        Session::put("adminflag",$res[0]->adminflag);
        echo "200-登录成功";

    }
//    用户列表
    public function userlist(Request $request){
        $page = $request->input("page",1);
        $num = $request->input("num",13);
        $ajax = $request->input("ajax","no");
        $sex = $request->input("sex","");
        $addr = $request->input("addr","");
        $age = $request->input("age","");
        $mryst = $request->input("mryst","");
        $phone = $request->input("phone","");
        if( $phone != '' ) {
            $sql = " select user.id as userid,user.phone,status,userattr.* from user inner join userattr on user.id=userattr.uid where user.phone='".$phone."' ";
            $res = DB::select($sql);
            return view("admin.userlist",["list"=>$res,"fenye"=>""]);
        }
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
        $count = DB::select("select count(*) as cnt from user inner join userattr on user.id=userattr.uid where user.status=1 ".$where);
//        exit("select user.id as userid,userattr.* from user left join userattr on user.id=userattr.uid where user.status=1 ".$where);
        $sql = " select user.id as userid,user.phone,status,userattr.* from user inner join userattr on user.id=userattr.uid where 1=1 ".$where." order by user.id desc limit ?,? ";
        $res = DB::select($sql,[($page-1)*$num,$num]);
        if( $ajax == 'no' ) {
            return view("admin.userlist",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/admin/userlist",$page,$num,$search)]);
        }else{
            echo json_encode($res);
        }
    }

    public function fabutubu() {
        $types = DB::select("select * from tubutypes");
        return view("admin.fabutubu",["types"=>$types]);
    }
    public function updatetubu($tubuid) {

        $sql = " select * from tubuhuodong where id=? ";
        $res = DB::select($sql,[$tubuid]);
        $types = DB::select("select * from tubutypes");
        if( count($res) == 0 ) {
            return view("web.error",["content"=>'活动id不存在']);
        }else{
            return view("admin.updatetubu",["tubu"=>$res[0],"types"=>$types]);
        }

    }
//    上传图片
    public function uploadimg(Request $request) {
        $file = $request->file('file');
        if ($file->isValid()) {
            $imgname = time() .".". $file->getClientOriginalExtension();
            $destinationPath = base_path() . "/public/admin/data/images/";

            if( $file->move($destinationPath,$imgname) ) {
                // 返回图片名
                echo $imgname;
            }else{
                echo 400;
            }
        }
    }
//    发布徒步活动
    public function dofabutubu(Request $request) {
//        $sql = " insert into tubuhuodong (title,tuwen,types,howlong,startday,endday,price,mudidi,jingdian,neirong,jihetime,jihedidian,qiangdu,  jiaotong,need,phone,leader,pictures,juli,tese) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ";
        $title = $request->input('title');
        $tuwen = $request->input('tuwen');
        $types = $request->input('types');
        $howlong = $request->input('howlong');
        $startday = $request->input('startday');
        $endday = $request->input('endday');
        $price = $request->input('price');
        $mudidi = $request->input('mudidi');
        $jingdian = $request->input('jingdian');
        $neirong = $request->input('neirong');
        $jihetime = $request->input('jihetime');
        $jihedidian = $request->input('jihedidian');
        $qiangdu = $request->input('qiangdu');
        $jiaotong = $request->input('jiaotong');
        $need = $request->input('need');
        $phone = $request->input('phone');
        $leader = $request->input('leader');
        $pictures = $request->input('pictures');
        $juli = $request->input('juli');
        $tese = $request->input('tese');
        $sql = " insert into tubuhuodong (title,tuwen,types,howlong,startday,endday,price,mudidi,jingdian,neirong,jihetime,jihedidian,qiangdu,jiaotong,need,phone,leader,pictures,juli,tese) values ('".$title."','".$tuwen."','".$types."','".$howlong."','".$startday."','".$endday."','".$price."','".$mudidi."','".$jingdian."','".$neirong."','".$jihetime."','".$jihedidian."','".$qiangdu."','".$jiaotong."','".$need."','".$phone."','".$leader."','".$pictures."','".$juli."','".$tese."') ";
        $res = DB::insert($sql,[]);
        if( $res ) {
            echo "200";
        }else{
            echo "400-发布失败";
        }
    }
    public function doupdatetubu(Request $request) {
        $sql = " update tubuhuodong set title=?,tuwen=?,types=?,howlong=?,startday=?,endday=?,price=?,mudidi=?,jingdian=?,neirong=?,jihetime=?,jihedidian=?,qiangdu=?,jiaotong=?,need=?,phone=?,leader=?,pictures=?,juli=?,tese=? where id=?";
        $res = DB::update($sql,[$request->input('title'),$request->input('tuwen'),$request->input('types'),$request->input('howlong'),$request->input('startday'),$request->input('endday'),$request->input('price'),$request->input('mudidi'),$request->input('jingdian'),$request->input('neirong'),$request->input('jihetime'),$request->input('jihedidian'),$request->input('qiangdu'),$request->input('jiaotong'),$request->input('need'),$request->input('phone'),$request->input('leader'),$request->input('pictures'),$request->input('juli'),$request->input('tese'),$request->input('tubuid')]);
        if( $res ) {
            echo "200";
        }else{
            echo "400-没有做任何修改";
        }
    }

    public function tubulist(Request $request) {
        $page = $request->input('page',1);
        $num = $request->input('num',20);
        $count = DB::select(" select count(*) as cnt from tubuhuodong ");
        $sql = " select tubuhuodong.*,tubutypes.name as typename from tubuhuodong left join tubutypes on tubutypes.id=tubuhuodong.types order by paixu desc,id desc limit ".($page-1)*$num.", ".$num;
        $res = DB::select($sql);
        return view("admin.tubulist",['tubulist'=>$res,"fenye"=>fenye($count[0]->cnt,"/admin/tubulist",$page,$num)]);
    }
    public function fabuproduct() {
        $sql = " select shopsort.*,shopsubsort.id as subid,shopsubsort.pid,shopsubsort.title as subtitle,shopsubsort.sort as subsort from shopsort left join shopsubsort on shopsort.id=shopsubsort.pid order by shopsort.sort desc,shopsubsort.sort desc ";
        $fenlei = DB::select($sql);
        return view("admin.fabuproduct",["fenlei"=>json_encode($fenlei)]);
    }

    public function dofabuproduct(Request $request) {
        $sql = " insert into product (title,tuwen,sort,subsort,price,sold,youfei,kucun,colorlist,chicunlist,pictures) values (?,?,?,?,?,?,?,?,?,?,?) ";
        $res = DB::insert($sql,[$request->input('title'),$request->input('tuwen'),$request->input('sort'),$request->input('subsort'),$request->input('price'),$request->input('sold'),$request->input('youfei'),$request->input('kucun'),$request->input('colorlist'),$request->input('chicunlist'),$request->input('pictures')]);
        if( $res ) {
            echo "200";
        }else{
            echo "400-发布失败";
        }
    }
    public function productlist(Request $request) {
        $page = $request->input('page',1);
        $num = $request->input('num',20);
        $count = DB::select(" select count(*) as cnt from product ");
        $sql = " select * from product order by id desc limit ".($page-1)*$num.", ".$num;
        $res = DB::select($sql);
        return view("admin.productlist",['list'=>$res,"fenye"=>fenye($count[0]->cnt,"/admin/productlist",$page,$num)]);
    }
    public function updateproduct($pid) {
        $sql = " select * from product where id=? ";
        $res = DB::select($sql,[$pid]);
        if( count($res) == 0 ) {
            return view("web.error",["content"=>'商品不存在']);
        }else{
            $sql = " select shopsort.*,shopsubsort.id as subid,shopsubsort.pid,shopsubsort.title as subtitle,shopsubsort.sort as subsort from shopsort left join shopsubsort on shopsort.id=shopsubsort.pid order by shopsort.sort desc,shopsubsort.sort desc ";
            $fenlei = DB::select($sql);
            return view("admin.updateproduct",["data"=>$res[0],"fenlei"=>json_encode($fenlei)]);
        }
    }
    public function doupdateproduct(Request $request) {
        $sql = " update product set title=?,tuwen=?,sort=?,subsort=?,price=?,sold=?,youfei=?,kucun=?,colorlist=?,chicunlist=?,pictures=? where id=? ";
        $res = DB::insert($sql,[$request->input('title'),$request->input('tuwen'),$request->input('sort'),$request->input('subsort'),$request->input('price'),$request->input('sold'),$request->input('youfei'),$request->input('kucun'),$request->input('colorlist'),$request->input('chicunlist'),$request->input('pictures'),$request->input('pid')]);
        if( $res ) {
            echo "200";
        }else{
            echo "400-没有做任何修改";
        }
    }
    public function adminlist() {
        $sql = " select * from admin ";
        $res = DB::select($sql);
        return view("admin/adminlist",["list"=>$res]);
    }
    public function settubutypes() {
        $sql = " select * from tubutypes ";
        $res = DB::select($sql);
        return view("admin.setting.tubutypes",["list"=>$res]);
    }
    public function zixunlist(Request $request) {
        $page = $request->input("page",1);
        $num = $request->input("num",20);
        $json = $request->input("json","no");
        $sql = " select * from zixun order by id desc limit ?,?";
        $res = DB::select($sql,[($page-1)*$num,$num]);
        $count = DB::select("select count(*) as cnt from zixun ");
        if( $json == "no" ) {
            return view("admin.zixunlist",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/admin/zixunlist",$page,$num)]);
        }else{
            echo json_encode($res);
        }
    }
    public function fabuzixun() {
        return view("admin.fabuzixun");
    }
    public function updatezixun($id) {
        $sql = " select * from zixun where id=? ";
        $res = DB::select($sql,[$id]);
        if( count($res) == 0 ) {
            return view("web.error",["content"=>'资讯不存在']);
        }else{
            return view("admin.updatezixun",["data"=>$res[0]]);
        }

    }
    public function setbanner() {
        $sql = " select * from banner order by id desc";
        $res = DB::select($sql);
        return view("admin.setting.banner",["list"=>$res]);
    }
    public function monidenglu($userid) {
        $sql = " select user.*,userattr.uname from user left join userattr on user.id=userattr.uid where user.id=?";
        $res = DB::select($sql,[$userid]);
        Session::put('uid', $res[0]->id);
        Session::put('uname', $res[0]->uname);
        return redirect("/user/".$userid);
    }
    public function fabudasai(){
        return view("admin.fabudasai");
    }
    public function fabuyouji() {
        return view("admin.fabuyouji");
    }
    public function updateyouji($id) {
        $sql = " select * from youji where id=? ";
        $res = DB::select($sql,[$id]);
        if( count($res) == 0 ) {
            return view("web.error",["content"=>'游记不存在']);
        }else{
            return view("admin.updateyouji",["data"=>$res[0]]);
        }

    }
    public function youjilist(Request $request) {
        $page = $request->input("page",1);
        $num = $request->input("num",17);
        $count = DB::select(" select count(*) as cnt from youji ");
        $sql = " select * from youji order by id desc limit ?,? ";
        $res = DB::select($sql,[($page-1)*$num,$num]);
        return view("admin.youjilist",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/admin/youjilist",$page,$num)]);
    }
    public function youjilist2(Request $request,$type=1) {
        $page = $request->input("page",1);
        $num = $request->input("num",17);
        $count = DB::select(" select count(*) as cnt from youji where type= ".$type);
        $sql = " select * from youji where type=? order by id desc limit ?,? ";
        $res = DB::select($sql,[$type,($page-1)*$num,$num]);
        return view("admin.youjilist",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/admin/youjilist/".$type,$page,$num)]);
    }
    public function dasailist(Request $request) {
        $page = $request->input("page",1);
        $num = $request->input("num",7);
        $count = DB::select(" select count(*) as cnt from dasai ");
        $sql = " select * from dasai order by id desc limit ?,? ";
        $res = DB::select($sql,[($page-1)*$num,$num]);
        return view("admin.dasailist",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/admin/dasailist",$page,$num)]);
    }
    public function updatedasai($id) {
        $sql = " select * from dasai where id=? ";
        $res = DB::select($sql,[$id]);
        if( count($res) == 0 ) {
            return view("web.error",["content"=>'大赛不存在']);
        }else{
            return view("admin.updatedasai",["data"=>$res[0]]);
        }
    }
    public function shopbanner() {
//        die("999");
        $sql = " select * from shopbanner order by id desc";
        $res = DB::select($sql);
        return view("admin.setting.shopbanner",["list"=>$res]);
    }

    public function shopfenlei() {
        $sql = " select shopsort.*,shopsubsort.id as subid,shopsubsort.pid,shopsubsort.title as subtitle,shopsubsort.sort as subsort from shopsort left join shopsubsort on shopsort.id=shopsubsort.pid order by shopsort.sort desc,shopsubsort.sort desc ";
        $res = DB::select($sql);
        return view("admin.setting.shopfenlei",["fenlei"=>json_encode($res)]);
    }
    public function singlepage() {
        $sql = " select * from singlepage order by id desc";
        $res = DB::select($sql);
        return view("admin.singlepage",["list"=>$res]);
    }
    public function editfooter() {
        $sql = " select * from options where title='footer' limit 1 ";
        $res = DB::select($sql);
        return view("admin.setting.editfooter",["data"=>$res[0]]);

    }
    public function mianban() {
        $sql = " select * from options where title='mianban' limit 1 ";
        $res = DB::select($sql);
        return view("admin.setting.mianban",["data"=>$res[0]]);
    }
    public function shoporder(Request $request) {
        $page = $request->input("page",1);
        $num = $request->input("num",20);
        $count = DB::select(" select count(*) as cnt from shoporder ");
        $sql = " select shoporder.*,user.phone,product.title from shoporder left join user on user.id=shoporder.uid left join product on shoporder.shopid=product.id order by shoporder.id desc limit ?,? ";
        $res = DB::select($sql,[($page-1)*$num,$num]);
        return view("admin.shoporder",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/admin/shoporder",$page,$num)]);
    }
    public function tubuorder(Request $request) {
        $page = $request->input("page",1);
        $num = $request->input("num",20);
        $count = DB::select(" select count(*) as cnt from tubuorder ");
        $sql = " select tubuorder.*,tubuhuodong.title from tubuorder left join userattr on tubuorder.uid=userattr.uid left join tubuhuodong on tubuorder.tid=tubuhuodong.id order by tubuorder.id desc limit ?,? ";
        $res = DB::select($sql,[($page-1)*$num,$num]);
        return view("admin.tubuorder",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/admin/tubuorder",$page,$num)]);
    }

    public function payorder(Request $request) {
        $orderid = $request->input("orderid",'');
        if( trim($orderid) != '' ) {
            $sql = " select * from payment where orderid=? ";
            $res = DB::select($sql,[$orderid]);
            return view("admin.payorder",["list"=>$res,"fenye"=>'']);
        }else{
            $page = $request->input("page",1);
            $num = $request->input("num",20);
            $count = DB::select(" select count(*) as cnt from payment ");
            $sql = " select * from payment  order by id desc limit ?,? ";
            $res = DB::select($sql,[($page-1)*$num,$num]);
            return view("admin.payorder",["list"=>$res,"fenye"=>fenye($count[0]->cnt,"/admin/payorder",$page,$num)]);
        }
    }

    public function exportfenche($tid) {
        $sql = " select tubuorder.*,tubuhuodong.price from tubuorder inner join tubuhuodong on tubuhuodong.id=tubuorder.tid where tid=? and orderid<>'0' order by fenche asc ";
        $res = DB::select($sql,[$tid]);
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("fenche_data");
        $objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(30);
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '分车号')
            ->setCellValue('B1', '联系人')
            ->setCellValue('C1', '联系电话')
            ->setCellValue('D1', '游客信息')
            ->setCellValue('E1', '集合点')
            ->setCellValue('F1', '付款')
            ->setCellValue('G1', '备注')
            ->setCellValue('H1', '订单时间');
        for( $i=0;$i<count($res);$i++ ) {
            $youkes = json_decode($res[$i]->youkes);
            $youkestr = "";
            for( $j=0;$j<count($youkes);$j++ ) {
//                $youkestr .= '#'.$youkes[$j]->name.",".$youkes[$j]->mobile.",".$youkes[$j]->idcard;
                $youkestr .= '#'.$youkes[$j]->name.",".$youkes[$j]->mobile;
            }
            $youkestr = trim($youkestr,"#");
            $objPHPExcel->getActiveSheet()->getRowDimension($i+2)->setRowHeight(30);
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A'.($i+2), $res[$i]->fenche."号车")
                ->setCellValue('B'.($i+2), $res[$i]->realname."(".$res[$i]->num."人)")
                ->setCellValue('C'.($i+2), $res[$i]->mobile)
                ->setCellValue('D'.($i+2), $youkestr)
                ->setCellValue('E'.($i+2), $res[$i]->jihe)
                ->setCellValue('F'.($i+2), "￥".$res[$i]->num*$res[$i]->price)
                ->setCellValue('G'.($i+2), $res[$i]->mark)
                ->setCellValue('H'.($i+2), $res[$i]->ordertime);
        }

        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(55);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

        $objPHPExcel->getActiveSheet()->setTitle('分车数据');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="分车数据.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter =PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
//    活动报名情况
    public function baominginfo(Request $request,$tid) {
        $page = $request->input("page",1);
        $num = $request->input("num",100);
        $count = DB::select(" select count(*) as cnt from tubuorder where tid=? ",[$tid]);

        $sql = " select tubuorder.*,tubuhuodong.title,tubuhuodong.price from tubuhuodong left join tubuorder on tubuorder.tid=tubuhuodong.id where tubuorder.tid=? order by id desc limit ?,?";
        $res = DB::select($sql,[$tid,($page-1)*$num,$num]);

        if( count($res) == 0 ) {
            return view("web.error",["content"=>"活动不存在"]);
        }else{
            $cntnum = DB::select(" select sum(num) as cnt from tubuorder where tid=? and orderid<>'0' ",[$tid]);
            $cntmoney = $cntnum[0]->cnt*$res[0]->price;
            return view("admin.baominginfo",["list"=>$res,"cntmoney"=>$cntmoney,"cnt"=>$cntnum[0]->cnt,"fenye"=>fenye($count[0]->cnt,"/admin/baominginfo/".$tid,$page,$num)]);
        }
    }

}