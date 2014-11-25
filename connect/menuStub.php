<?php
//require_once dirname(__FILE__) . '/../common/Common.php';
require_once dirname(__FILE__).'/tokenStub.php';
require_once dirname(__FILE__).'/doCurlRequest.php';//cURL的函数


/*
这是一个自定义菜单的基本实现类
大致流程：1.获取access_token 2.对数据$data进行json编码 3.发送到微信指定https地址


*/
class menuStub {
	public static function create($account,$data) {
		$ret = menuStub::reqMenu($account,"menu/create", $data);
		if(false === $ret) {
			return false;
		}
		return true;
	}	
	public static function get($account) {
		$ret = menuStub::reqMenu($account,"menu/get", array());
		if(false === $ret) {
			return false;
		}
		return $ret;
	} 	
	public static function delete($account){
		$ret = menuStub::reqMenu($account,"menu/delete", array());
		if(false === $ret) {
			return false;
		}
		return true;
	}



	public static function reqMenu($account,$interface, $data) {
		$token = tokenStub::getToken($account);
		//retry 3 times
		$retry = 3;
		while ($retry) {
			$retry --;
			if(false  === $token) {
				interface_log(DEBUG, EC_OTHER, "get token error!");
				return false;
			}
			
			$url = WX_API_URL . "$interface?access_token=" . $token;	
            $json_data = json_encode($data,JSON_UNESCAPED_UNICODE);
			interface_log(DEBUG, 0, "req url:" . $url . "  req data:" . $json_data);
            
            $ret = doCurlRequest::doCurlPosthttpsRequest($url, $json_data);
			interface_log(DEBUG, 0, "response:" . $ret);
			
			$retData = json_decode($ret, true);
			if(!$retData || $retData['errcode']) {
				interface_log(DEBUG, EC_OTHER, "req create menu error");
				if($retData['errcode'] == 40014) {//不合法的access_token 
					$token = tokenStub::getToken(true);
				}
			} else {
				return $retData;
			}
		}
		
		return false;
	}
	

}