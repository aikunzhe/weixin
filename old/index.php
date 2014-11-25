<?php

//必要文件
require_once dirname(__FILE__).'/model/GlobalDefine.php';

//引入日志 函数 非类
require_once LOG4PHP;

//获取当前时间戳
$startTime = microtime(true);



//引入请求对象
require_once dirname(__FILE__) . '/model/login.class.php';

$login  = new wechatCallbacklogin();

if($login->checkSignature()) {
	if($_GET["echostr"]) {//有数据证明 只是 接入请求
		echo $_GET["echostr"];
		exit(0);
	}
} else {
    //验证失败 非法接入
	//恶意请求：获取来来源ip，并写日志
	$ip = getIp();//这个方法在日志库里
	interface_log(ERROR, EC_OTHER, 'malicious(恶意的): ' . $ip);
	exit(0);	
}

$postStr =$GLOBALS["HTTP_RAW_POST_DATA"];
//$postStr = file_get_contents ( "php://input" );

interface_log(INFO, EC_OK, "");
interface_log(INFO, EC_OK, "***********************************");
interface_log(INFO, EC_OK, "***** interface request start *****");
interface_log(INFO, EC_OK, 'request:' . $postStr);
interface_log(INFO, EC_OK, 'get:' . var_export($_GET, true));





if (empty ( $postStr )) {    
    echo 'error input!';
	interface_log(ERROR, EC_OK, "error input!" );
	interface_log(INFO, EC_OK, "***** interface request end *****");
	interface_log(INFO, EC_OK, "*********************************");
	interface_log(INFO, EC_OK, "");
	exit ( 0 );
}
function getWeChatObj($toUserName) {
        interface_log(INFO, EC_OK, "id是$toUserName"."地址".dirname(__FILE__) . '/model/WeChatCallBackEchoServer.php'.USERNAME_ES);
	if($toUserName == USERNAME_FINDFACE) {
		require_once dirname(__FILE__) . '/model/WeChatCallBackFindFace.php';
		return new WeChatCallBackFindFace();
	}
	if($toUserName == USERNAME_MR) {
		require_once dirname(__FILE__) . '/class/WeChatCallBackMeiri10futu.php';
		return new WeChatCallBackMeiri10futu();
	}
	if($toUserName == USERNAME_ES) {
		require_once dirname(__FILE__) . '/model/WeChatCallBackEchoServer.php';

		return new WeChatCallBackEchoServer();
	}
	if($toUserName == USERNAME_MYZL) {
		require_once dirname(__FILE__) . '/class/WeChatCallBackMYZL.php';
		return new WeChatCallBackMYZL();
	}
    //都没有 则返回基础类 
	require_once dirname(__FILE__) . '/model/WeChatCallBack.php';
	return  new WeChatCallBack();
}


// 获取参数
$postObj = simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );
if(NULL == $postObj) {
	interface_log(ERROR, 0, "can not decode xml");	
	exit(0);
}

$toUserName = ( string ) trim ( $postObj->ToUserName );
if (! $toUserName) {
	interface_log ( ERROR, EC_OK, "error input!" );
	exitErrorInput();
} else {
    //根据传入的微信号ID 选择使用的模板
	$wechatObj = getWeChatObj ( $toUserName );
}
$ret = $wechatObj->init ( $postObj );
if (! $ret) {
	interface_log ( ERROR, EC_OK, "error input!" );
	exitErrorInput();
}
//执行WeChatCallBac***方法
$retStr = $wechatObj->process();
interface_log ( INFO, EC_OK, "response:" . $retStr );
//echo $retStr;


interface_log(INFO, EC_OK, "***** interface request end *****");
interface_log(INFO, EC_OK, "*********************************");
interface_log(INFO, EC_OK, "");
$useTime = microtime(true) - $startTime;
interface_log ( INFO, EC_OK, "cost time:" . $useTime . " " . ($useTime > 4 ? "warning" : "") );


?>