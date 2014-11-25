<?php
require_once dirname(__FILE__) . '/SqlHelper.class.php';
/**
 * 对数据库单表的操作类 
 * @desc: 封装了对单表的增，删，改，查，取列等多种操作
 *
 */
class SingleTableOpera{

    /**
     * @param string $tableName 表名
     * @param string/object $dbKey $dbKey，默认为'DB'
     */
    private $_tableName;
    private $_db;
    
    function __construct($tableName="",$db='DB')
    {
        $this->_tableName = strtolower($tableName);
        $this->_db = $db;
    }
    
    /**
    * 设置tablename 
    **/
    function setTableName($tableName)
    {
        $this->_tableName = strtolower($tableName);
    }
    //获取tablename
    private function getTableName(&$args) {
        if (isset($args['_tableName'])) {
            $tableName = strtolower($args['_tableName']);
        } else {
            $tableName = $this->_tableName;
        }
        return $tableName;
    }
    
     /**
     * 读取数据
     * @author benzhan
     * @param array $args 参数列表，特殊参数前缀_
     */
    function getObject(array $args = array(), $or = 0) {
        $fetch = $args['_fetch'];
        $fetch || $fetch = 'getAll';        
        $field = $args['_field'];// 如果没有这个参数 表示 select * from
        $field || $field = "*";
        
        $tableName = $this->getTableName($args);

        /*
            $or 的值是什么意思？
            如果没有$args['_where']这个参数，就表示 where 1
        */
        if($or) {
       		$where = $args['_where'] ? $args['_where'] : '0'; 	
        } else {
        	$where = $args['_where'] ? $args['_where'] : '1';	
        }
        $sql = "SELECT $field FROM {$tableName} WHERE {$where} ";
        echo "$sql";
      
        $sqlhelper = new SqlHelper($this->_db);
        $resou = $sqlhelper->execute_dql_arry($sql);        
      
        return $resou;
        
      //构造条件部分 不明白
        /*
        $args = $this->_db->escape($args);
        foreach ($args as $key => $value) {
            if ($key[0] == '_') { continue; }
            
            if (is_array($value)) {
            	if($or) {
            		$sql .= "OR `{$key}` IN ('" . implode("','", $value) . "') ";	
            	}else {
            		$sql .= "AND `{$key}` IN ('" . implode("','", $value) . "') ";	
            	}
            } else {
               // $value && $sql .= "AND `{$key}` = '{$value}' ";
               if($or) {
               		$sql .= "OR `{$key}` = '{$value}' ";
               } else {
               		$sql .= "AND `{$key}` = '{$value}' ";	
               }
               
            }
        }
        
        //排序
        if ($args['_sortExpress']) {
            $sql .= "ORDER BY {$args['_sortExpress']} ";
            $sql .= $args['_sortDirection'] . ' ';
        }
        //标识是否锁行，注意的是也有可能锁表
        $args['_lockRow'] && $sql .= "FOR UPDATE ";
       
        return $this->_db->$fetch($sql, $args['_limit']);
        */
    }
    /**
    * 添加一条数据
    * 根据 MsgType 判断 数据的类型 从而决定使用什么数据表
    */
    function addObject($arr)
    {
/*要保证传入的数组 的 索引 与 数据表的列名 一致*/       

   $tableName = $this->getTableName($arr);   
   $str .= "INSERT INTO {$tableName} SET " . $this->genBackSql($arr, ', ');
           


        
        $sql = new SqlHelper($this->_db);
        $is = $sql->execute_dml($str);
        
       if($is==1){
           // echo "写入操作成功";
           interface_log(INFO, EC_OK, "*****写入数据库成功*****");
        }
        else if($is==0)
        {
            //echo "操作失败";
            interface_log(INFO, EC_OK, "***** 写入数据库失败*****");
        }else if($is==2)
        {
           // echo "有行受影响";
           interface_log(INFO, EC_OK, "*****没有数据写入数据库*****");
        }
        
    }    
        /**
     * 删除数据
     * @author benzhan
     * @param array $where 更新的条件
     */
    function delObject($where=array()) {
    
        $tableName = $this->getTableName($where);        
        $str = "DELETE FROM `{$tableName}` WHERE 1 " . $this->genFrontSql($where, 'AND ');
        
        $sql = new SqlHelper($this->_db);
        $is = $sql->execute_dml($str);
        
       if($is==1){
           // echo "写入操作成功";
           interface_log(INFO, EC_OK, "*****操作数据库成功*****");
        }
        else if($is==0)
        {
            //echo "操作失败";
            interface_log(INFO, EC_OK, "***** 操作数据库失败*****");
        }else if($is==2)
        {
           // echo "有行受影响";
           interface_log(INFO, EC_OK, "*****没有操作'数据库'的数据*****");
        }
       return $is;
    }
    
    
      /**
     * 把key => value的数组转化为前置连接字符串 
     * @author benzhan
     * @param array $args
     * @param string $connect
     */
    function genFrontSql(array $args, $connect = 'AND ') {
        $str = '';
        foreach ($args as $key => $value) {
        	if ($key[0] == '_') {
        		continue;
        	}
            if (is_array($value)) {
                $str .= "$connect `$key` IN ('" . join("','", $value) . "') "; 
            } else {
                $str .= "$connect `$key` = '$value' "; 
            }
        }
  
           return substr($str, 0, -strlen($connect));
    } 
    /**
     * 把key => value的数组转化为后置连接字符串 
     * @author benzhan
     * @param array $args
     * @param string $connect
     */
    function genBackSql($args, $connect = ', ') {
        $str = '';
        foreach ($args as $key => $value) {
            	$str .= "`$key` = '$value'" . $connect;	
            }
            
           return substr($str, 0, -strlen($connect));//删除最后一个字符 这里使用了负数来表示
   
    }    
    
    
    public static function getInstance($dbKey = 'DB') {
        if (array_key_exists($dbKey, self::$db))        {
            return self::$db[$dbKey];
        } 
        else {
            $newdb = new SqlHelper($dbKey);
            if ($newdb->connect()) {
                self::$db[$dbKey] = $newdb;
                return $newdb;
            } else {
                return false;
            }
        }
    }
}
?>