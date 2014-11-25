<?php
//必要文件
require_once dirname(__FILE__).'/model/WeChatCallBackEchoServer.php';
require_once dirname(__FILE__).'/model/GlobalDefine.php';

header("Content-type: text/html;charset=utf-8");
//引入日志 函数 非类
require_once LOG4PHP;




//$account='ES';
//tokenStub::getToken($account);


//引入数据库操作

 // $sto->delObject();//调用删除方法
 $id = "ofawzuP0ZRBozKjb5P69bpccWXMU";
$args['_where'] = "id = ( select max(id) from wx_test where userId='$id' and userAcction='text')";

$sto = new SingleTableOpera("account",'LO');
$rous = $sto->getObject();
echo "<pre>";
print_r($rous);



