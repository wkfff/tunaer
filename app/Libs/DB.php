<?php

/**
 * 数据库  mysqli  单例模式
 */
$dbconfig = array(

    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => 'tunaer', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'abc123!@#', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_CHARSET'=> 'utf8', // 字符集
    
);
/**
 * 通用数据库操作  单例
 */
class DB {

	//	数据库 链接句柄
	private $link   = null;
	// 最后插入id
	public $lastid = 0;
	//  DB实例
	private static $_instance = null;
	//  检测当前DB实例是否存在，存在就返回，不存在就新建
	static public function getInstance() {
		if (is_null ( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
	}
	public function atcommit($flag = true) {
		$this->link->autocommit($flag);
	}
	public function mycommit() {
		$this->link->commit();
	}
	public function myrollback() {
		$this->link->rollback();
	}
	public function link() {
		return $this->link;
	}

	private function __construct() {
		global $dbconfig;
		$this->link = new mysqli($dbconfig['DB_HOST'], $dbconfig['DB_USER'], $dbconfig['DB_PWD'], $dbconfig['DB_NAME']);
		$this->link->query("set names 'utf8'");
	}

	/**
	 * 添加数据
	 * @param [mix] $mix [一维数组或字符串]
	 * @param [string] $table [表名]
	 */
	public function add($table,$mix) {

		if ( !is_array($mix) ) {
			//   "name=>'张三'&passwd=>1234"
			$p = "/(?<=\=\>)[^&]+/";
			preg_match_all($p, $mix, $value);
			$p = "/\w+(?=\=\>)/";
			preg_match_all($p, $mix, $key);
			$sql = " insert into ".$table." (".implode(",", $key[0]).") values (".implode(",", $value[0]).") ";
		}else {
			$keys = array_keys($mix);
			$sql = " insert into ".$table." (".implode(",", $keys).") values (".implode(",", $mix).") ";
		}
		// $pos = file_get_contents(ROOT."/openapi/log.php");
		// file_put_contents(ROOT."/openapi/log.php", "[".date("H:i:s")."][".__FUNCTION__."] : ".$sql."\n\n");
		// file_put_contents(ROOT."/openapi/log.php", "\n\n".$pos,FILE_APPEND);
		return $this->excute($sql,false,true) ;

	}

	public function del($table,$where) {
		$sql = " delete from ". $table ." where  ".$where;
		
		return $this->excute($sql) ;
	}

	public function update($table,$data,$where) {
		//	"name='张三'&passwd=1234"
		$sql = " update ". $table ." set ". str_replace("&", ",", $data) ." where ". $where;
		// file_put_contents(ROOT."/log.txt",$sql."+++++++++++++++");
		return $this->excute($sql) ;
	}

	public function select($sql,$flag = true) {
		
		return $this->excute($sql,$flag) ;
	}

	public function query($sql) {
		
		return $this->link->query($sql);
	}

	// sql字符串查询
	public function excute($sql,$arr = false,$indertid = false) {
		
		if ( $result = $this->link->query($sql) ) {
			// $arr 用于判断当前是属于  select  还是  update,add delete 等操作
			// 默认是  false  就是非  select
			if( $arr ) {
				$res = array() ;
				while ($row = $result->fetch_assoc()) {
					array_push($res, $row);
			    }
			    // 返回一个二维数组
			    return $res ;
			}else {
				//返回自增id
				if( $indertid ) {
					return $this->link->insert_id;
				}
				//返回影响行数
				return $this->link->affected_rows;
				
				
			}
			
		}else {
			// 错误信息
			return $this->link->error ; 
		}
		

		 
	}

	function free() {
		$this->link->close();
		$this->link   = null;
		self::$_instance = null;

	}

}