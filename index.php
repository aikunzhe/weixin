<?php

//必要文件
require_once dirname(__FILE__).'/date/GlobalDefine.php';
//引入日志 函数 非类
require_once dirname(__FILE__).'/model/log4/log4_include.php';

//获取当前时间戳
$startTime = microtime(true);


//调用 判断合法服务器 的控制器
require_once dirname(__FILE__).'/control/login_process.php';

/*能往下执行 证明验证服务器成功 往下执行*/

//接收微信后台发过来的 post数据
$postStr =$GLOBALS["HTTP_RAW_POST_DATA"];

//写入日志
interface_log(INFO, EC_OK, "");
interface_log(INFO, EC_OK, "***********************************");
interface_log(INFO, EC_OK, "***** interface request start *****");
interface_log(INFO, EC_OK, 'request:' . $postStr);
interface_log(INFO, EC_OK, 'get:' . var_export($_GET, true));


if (empty ( $postStr )) {    //获取数据失败
    echo 'error input!';
	interface_log(ERROR, EC_OK, "error input!" );
	interface_log(INFO, EC_OK, "***** interface request end *****");
	interface_log(INFO, EC_OK, "*********************************");
	interface_log(INFO, EC_OK, "");
	exit ( 0 );
}

function getWeChatObj($toUserName) {
	if($toUserName == USERNAME_FINDFACE) {
		require_once dirname(__FILE__) . '/connect/WeChatCallBackFindFace.php';
		return new WeChatCallBackFindFace();
	}
	if($toUserName == USERNAME_MR) {
		require_once dirname(__FILE__) . '/connect/WeChatCallBackMeiri10futu.php';
		return new WeChatCallBackMeiri10futu();
	}
	if($toUserName == USERNAME_ES) {
		require_once dirname(__FILE__) . '/connect/WeChatCallBackEchoServer.php';

		return new WeChatCallBackEchoServer();
	}
	if($toUserName == USERNAME_MYZL) {
		require_once dirname(__FILE__) . '/connect/WeChatCallBackMYZL.php';
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
interface_log(INFO, EC_OK, "***** interface request end *****");
interface_log(INFO, EC_OK, "*********************************");
interface_log(INFO, EC_OK, "");
$useTime = microtime(true) - $startTime;
interface_log ( INFO, EC_OK, "cost time:" . $useTime . " " . ($useTime > 4 ? "warning" : "") );


?>