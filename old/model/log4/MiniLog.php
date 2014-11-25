<?php
/*
需要获取他的实例时，请求他的公有静态函数instance即可

*/

class MiniLog {
	private static $_instance;//单例
	private $_path;//日志目录
	private $_pid;//进程ID
	private $_handleArr;//保存不同日志级别文件fd
	
    /*$path 日志对象对应的日志目录
    */
	function __construct($path) {
		$this->_path = $path;
		$this->_pid = getmypid();
		
	}
	
	private function __clone() {		
	}
	/*单例函数*/
	public static function instance($path = '/tmp/') {
		if(!(self::$_instance instanceof self)) {
			self::$_instance = new self($path);
		}
		
		return self::$_instance;
	}
	/*根据文件名 获取文件fd*/
	private	function getHandle($fileName) {
		if($this->_handleArr[$fileName]) {
			return $this->_handleArr[$fileName];
		}
		date_default_timezone_set('PRC');
		$nowTime = time();
		$logSuffix = date('Ymd', $nowTime);
		$handle = fopen($this->_path . '/' . $fileName . $logSuffix . ".log", 'a');
		$this->_handleArr[$fileName] = $handle;
		return $handle;
	}
	/*向文件中写日志*/
	public function log($fileName, $message) {
		$handle = $this->getHandle($fileName);
		$nowTime = time();
		$logPreffix = date('Y-m-d H:i:s', $nowTime);
		fwrite($handle, "[$logPreffix][$this->_pid]$message\n");
		return true;
	}
	
    /*析构函数 关闭fd*/
	function __destruct(){
		foreach ($this->_handleArr as $key => $item) {
			if($item) {
				fclose($item);
			}
		}
	}
}

?>