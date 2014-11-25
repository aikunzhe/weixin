<?php

//引入请求对象
require_once dirname(__FILE__) . '/../model/login.class.php';

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
