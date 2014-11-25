<?php
require_once dirname(__FILE__).'/SqlDbException.php';//sql的错误信息 抛异常
//require_once dirname(__FILE__).'/GlobalFunctions.php';
//require_once dirname(__FILE__) .'/GlobalDefine.php';

/*	private $mysqli;
	    private static $host="172.18.203.77";
		private static $user="root";
		private static $password="hello";
		private static $db="music_db"; 
		function __construct()
		{
			//创建MySqli对象
			$this->mysqli = new mysqli(self::$host,self::$user,self::$password,self::$db);
			if(	$this->mysqli->connect_error)
			{
				die("链接失败".$this->mysqli->connect_error);
			}
			//设置默认字符编码 
			$this->mysqli->set_charset("utf8");
		}
        
        */

//这是一个Sql工具类
	class SqlHelper
	{
		private $mysqli;
        protected $_dbKey;	

		  //建立链接 
		function __construct($dbKey='DB')
		{        
           $this->_dbKey = $GLOBALS['DB'][$dbKey];//getConf('ROUTE.'.$dbKey);
            /*
            在./GlobalDefine.php 定义一个全局数组$DB        
            */      
            //先导入变量
            $dbHost = $this->_dbKey ["HOST"];
            $dbName = $this->_dbKey ["DBNAME"];
            $dbUser = $this->_dbKey ["USER"];
            $dbPass = $this->_dbKey ["PASSWD"];
            $dbPort = (int)$this->_dbKey ["PORT"];

            //创建MySqli对象
            $this->mysqli = new mysqli($dbHost,$dbUser,$dbPass,$dbName,$dbPort);     
            if(	$this->mysqli->connect_error)
            {       
                new DB_Exception( 'mysqli fail!链接失败:');
                die;        
            }
            //设置默认字符编码 
            $this->mysqli->set_charset("utf8");    
		}
     
     	//返回结果集 //需要手动释放资源 不推荐
		function execute_dql($sql)
		{
			$res = $this->mysqli->query($sql); 
            if($res===false)
            {
               new DB_Exception("操作失败".$this->mysqli->error);
               exit;
            }
			return $res;
		}
        //返回结果集的数组 推荐
		function execute_dql_arry($sql)
		{
			$arr = array();
			$res = $this->mysqli->query($sql);     
            
            if($res===false)
            {
               new DB_Exception("操作失败".$this->mysqli->error);
               die;
            }
            
			$i=0;
			while($row=$res->fetch_assoc() )
			{
				$arr[$i++] = $row;
			}
			$res->free();
			//返回结果集的数组
			return $arr;
		}      
		
		function execute_dml($sql)
		{
			$res = $this->mysqli->query($sql);
            if($res===false)
            {
              //  "操作失败"
                return 0; 
            }
			else
			{
				if($this->mysqli->affected_rows>0)
				{
					//$i = $this->mysqli->affected_rows;
				//	echo '$this->mysqli->affected_rows='."$i";
					return 1;//表示操作成功
				}
				else
				{	
					return 2;//表示没有行数受影响
				}
			}
			
		}
        
        function execute_dql_fenye($sql1, $sql2, &$page_turn)
		{		
        //$page_turn是一个分页专用的对象
			//$sql1="select * from 表名 where  limit 0 ,6" 用来获取分页数据

			//查询要分页的数据 		
			$res = $this->mysqli->query($sql1) or die("操作失败".$this->mysqli->error);
			//讲数据导出到数组
			$arr = array();
			while($row=$res->fetch_assoc())
			{
				$arr[] = $row;
			}
// 			将数组的数据赋给对象的成员
			$page_turn->res_array = $arr;
// 			释放结果集资源
			$res->free();
            
			//$sql2="select count(id) form 表名" 用来获取分页需要的 信息（ $rowcount;  $pageCount）			
			
			$res = $this->mysqli->query($sql2) or die("操作失败".$this->mysqli->error);
			if($row = $res->fetch_row())
			{
                //获取一共有多少条数据
                $page_turn->rowCount = $row[0];
                //一共有多少页
				$page_turn->pageCount = ceil ( $row [0] / $page_turn->pageSize);				
				
			}
			$res->free();			
		}
        
		function __destruct()
		{
			       //关闭连接
			//$this->mysqli->close();
		}
	}

 
 ?> 


