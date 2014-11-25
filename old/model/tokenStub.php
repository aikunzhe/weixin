<?php
//require_once dirname(__FILE__) . '/../common/Common.php';
require_once dirname(__FILE__).'/SingleTableOpera.php';
require_once dirname(__FILE__).'/doCurlRequest.php';//cURL的函数


/**
* getToken()  获取$account 所指定的公众号的access_token
**/

class tokenStub {
	public static function getToken($account,$force = false) {
/*
    检查 APPID_APPSECRET[$account]这个二维数组中 是否有对应的appId 和 appSecret
*/
        if( !($GLOBALS['APPID_APPSECRET'][$account]['appId'] && $GLOBALS['APPID_APPSECRET'][$account]['appSecret']))
        {
        	interface_log(DEBUG, 0, "$account appId or appSecret not exists"); 
            return false;
        }
        try {
            //引入数据库操作
            $sto = new SingleTableOpera("wx_ctoken",'DB');
        /*  $force true 表示不检查we_ctoken表 是否有未过期的access_token
            $force false 表示检查we_ctoken表 是否有未过期的access_token，有数据—>有未过期 就直接返回    
        */                
			if($force == false) {
				$ret = $sto->getObject();

				interface_log(DEBUG, 0, "token data get from 数据库 wx_ctoken: " . json_encode($ret));
				if(count($ret) == 1) {//数据库有数据 待测试              
					$token = $ret[0]['token'];
					$expire = $ret[0]['expire'];
					$addTimestamp = $ret[0]['addTimestamp'];
					$current = time();
                    /*检查表we_ctoken 中的 access_token是否过期，这里设置提前30秒过期，减少接口调用的是过期的access_token （因为判断access_token 和 使用access_token是有时间差的）*/
                      
                    if($addTimestamp + $expire - 30 > $current) {//未过期
                        return $token;
					}	
				}
			}
			//发起https请求  组装 请求数据
			$para = array(
				"grant_type" => "client_credential",//获取access_token时填写client_credential 
				"appid" => $GLOBALS['APPID_APPSECRET'][$account]['appId'],
                // 	第三方用户唯一凭证 
				"secret" => $GLOBALS['APPID_APPSECRET'][$account]['appSecret']//第三方用户唯一凭证密钥，即appsecret 
			);
			
			$url = WX_API_URL . "token";
			interface_log(DEBUG, 0, "url:" . $url . "  req data:" . json_encode($para));
            //发送请求 这里使用了一个封装好的函数
			$ret = doCurlRequest::doCurlGetHttpsRequest($url, $para);
			interface_log(DEBUG, 0, "response data:" . $ret);
			//接收数据 （以数组的方式返回）
			$retData = json_decode($ret, true);
                 
			if(!$retData || $retData['errcode']) {//没有返回数据 或者返回失败
				interface_log(ERROR, EC_OTHER, "can not requst token from weixin  error");
				return false;
			}
            
			$token = $retData['access_token'];
			$expire = $retData['expires_in'];
            $appid  = $GLOBALS['APPID_APPSECRET'][$account]['appId'];
			$sto->delObject();
			$sto->addObject(array("appId" =>$appid ,'token' => $token, "expire" => $expire, "addTimestamp" => time()));
			
			return $token;
			
		} catch (Exception $e) {
			interface_log(ERROR, EC_DB_OP_EXCEPTION, "operate ctoken error! msg:" . $e->getMessage());
			return false;
		}
		
		
	}
}

/* 
echo "打印数据库取得的数据";
echo"<pre>";
print_r($ret);
exit; 

*/