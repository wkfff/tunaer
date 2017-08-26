<?php


/**
 * Memcached的封装  单例模式
 * 主要用来 存储 openapi 访问所需的 token
 */

class Mycached {
	/**
	 * Memcache 连接句柄
	 */
	private $link  = null;

	//  Memcache实例
	private static $_instance = null;

	/**
	 * 检测当前Memcache实例是否存在，存在就返回，不存在就新建
	 * @return [type] [description]
	 */
	static public function getInstance() {


		if (is_null ( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
	}
	/**
	 * 构造函数
	 * 设置为私有禁止实例化
	 */
	private function __construct() {
		// 检测memcached模块是否可用
		if ( !extension_loaded('memcached') ) {
            return false;
        }
		$this->link = new Memcached();
		$this->link->addServer('localhost', 11211);
		// 当数据大于2k时，以0.2的压缩比进行zlib
		// $this->link->setCompressThreshold(2000, 0.2);
	}

	/**
     * 读取缓存
     * @access public
     * @param string $name 缓存变量名
     * @return mixed
     */
	public function get($name) {
		return $this->link->get($name);
	}

	/**
     * 删除缓存
     * @access public
     * @param string $name 缓存变量名
     * @return boolean
     */
    public function rm($name, $ttl = false) {
        $this->link->delete($name);
    }

	/**
     * 写入缓存
     * @access public
     * @param string $name 缓存变量名
     * @param mixed $value  存储数据
     * @param boolean $zlib  是否压缩数据
     * @param integer $expire  有效时间（秒）
     * @return boolean
     */
	public function set($name, $value, $expire = 1200) {

        if( is_object($value) || is_array($value) ) {
			$value = serialize($value);
		}

		if( !$this->link->set($name, $value,$expire) ) {
			return false;
		}
		return true;

	}

	/**
     * 清除缓存
     * @access public
     * @return boolean
     */
    public function clear() {
        return $this->link->flush();
    }
}

