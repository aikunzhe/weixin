<?php
/*
*数据库连接类，不建议直接使用DB，而是对DB封装一层  
*这个类不会被污染，不会被直接调用  
*/
class DB{
//pdo对象
private $_pdo = null;
//用于存放实例化的对象  
static private $_instance = null;  

	//公共静态方法获取实例化的对象  
    static public function getInstance() {  
        if (!(self::$_instance instanceof self)) {  
            self::$_instance = new self();  
        }  
        return self::$_instance;  
    } 
	
	//私有构造  
    private function __construct($dbKey='MR') {  
        $_dbKey= $GLOBALS['DB'][$dbKey];	
        $dsn =$_dbKey['DSN'];
        $user=$_dbKey['USER'];
        $pwd=$_dbKey['PASSWD'];
        $options=$_dbKey['DB_CHARSET'];

        try {  
        //连接数据库
            $this->_pdo = new PDO($dsn, $user, $pwd, array(PDO::MYSQL_ATTR_INIT_COMMAND=>'SET NAMES '.$options));  
                //错误报告模式  
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
        } catch (PDOException $e) {  
            exit($e->getMessage());  
        }  
    }  
    //执行 DML语句
    function execute_dml($str){
    //$str='INSERT INTO `admin`(`admin_name`, `admin_password`)VALUES ("小白","123")';
        try{
            $count = $this->_pdo->exec($str);
            if($count>0)
            {
                return 1;//表示操作成功
            }else if($count===0)
            {
                return 2;//表示没有行数受影响
            }else if($count===false)
            {
                return 0;//操作失败
            }            
        }catch(PDOException $e){
            return 0;//操作失败
            exit($e->getMessage());  
        }			
    }
	
	//返回结果集的数组 推荐
    function execute_dql($str){
        //$str = "select * from `admin`";
        try
        {
            $objStatement = $this->_pdo->query($str);
            // — 为语句设置默认的获取模式
            $objStatement ->setFetchMode( PDO :: FETCH_ASSOC );
            //PDO::FETCH_ASSOC:返回一个"索引"为结果集的数组 a['id'] a['name']
            //PDO::FETCH_NUM:返回一个"关联"结果集的数组 a[0] a[1]
         
            //返回二维组数 是一个结果集
            return  $objStatement->fetchAll();
        }catch(PDOException $e){
            exit($e->getMessage()); 
        }

    }
	
}



/*//打印变量信息
echo $dbh->getAttribute(PDO::ATTR_CLIENT_VERSION ).'<br>';//返回 PDO 驱动所用客户端库的版本信息。 
echo $dbh->getAttribute(PDO::ATTR_CONNECTION_STATUS ).'<br>';//IP 端口 参数
echo $dbh->getAttribute(PDO::ATTR_SERVER_INFO ).'<br>';//返回一些关于 PDO 所连接的数据库服务的元信息。 
echo $dbh->getAttribute(PDO::ATTR_SERVER_VERSION ).'<br>';//返回 PDO 所连接的数据库服务的版本信息。 
echo $dbh->getAttribute(PDO::ATTR_DRIVER_NAME).'<br>';//返回驱动名称。 
*/




/*
//事务 mysql的引擎要指定为InnoDB
//数据库创建语句
$s=<<<EOF
create table zhangsan(
id   int primary key auto_increment,
money float null
)engine InnoDb default character set utf8 collate utf8_general_ci
EOF;

try{
// 开始一个事务，关闭自动提交 
 $dbh -> beginTransaction ();


//  更改数据库架构及数据 
$str1="UPDATE `music_db`.`zhangsan` SET `money` = '600' WHERE `id` = 1;";
$str2="UPDATE `music_db`.`lisi` SET `money` = '1400' WHERE `lisi`.`id` = 1;";
 $sth  =  $dbh -> exec ( $str1);
 $sth  =  $dbh -> exec ($str2);
 
 //执行事务操作
  $dbh -> commit (); 
// 数据库连接现在返回到自动提交模式 
}catch(PDOException $e){// 识别出错误并回滚更改
	$dbh -> rollBack ();
	echo $e->getMessage().'<br>';
	die();
}
*/

/*
//预处理 例子
try{
	//预编译对象 
	$str="insert into `music_db`.`zhangsan` SET `money` = :money";
	$objStatement = $dbh->prepare($str);
	//参数绑定
	$arr = array( 
	':money'  =>  1500 , 
	);
	//执行 成功时返回 TRUE ， 或者在失败时返回 FALSE 。 
	$objStatement ->execute($arr);

}catch(PDOException $e){// 识别出错误并回滚更改
	echo $e->getMessage().'<br>';
	die();
}

*/
