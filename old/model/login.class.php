<?php
class wechatCallbacklogin
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
        	echo $echoStr;
        	exit;
        }
    }

    public function responseMsg()
    {
		
        $PostData =$GLOBALS["HTTP_RAW_POST_DATA"];
        //$PostData = file_get_contents("php://input");

            if(!$PostData)
            {
                echo"Wrong input1";
                exit(0);
            }
    
    //解析XML字符串
    $xmlObj = simplexml_load_string($PostData,'SimpleXMLElement',LIBXML_NOCDATA);
    if(!$xmlObj)
    {
        echo"Wrong input2";
        exit(0);
    }
    // 	发送方帐号（一个OpenID）
    $fromusername = $xmlObj->FromUserName;
    // 	开发者微信号 
    $tousername =  $xmlObj->ToUserName;
    //消息类型
   $msgType = $xmlObj->MsgType;
   $regMsg;
   if( 'text'!= $msgType )
   {
        $regMsg = '只支持文本格式';
   }else
   {
        $content = $xmlObj->Content;
        $regMsg = $content;
   }
// 输出xml模板
    $retTmp = " <xml>
                     <ToUserName><![CDATA[%s]]></ToUserName>
                     <FromUserName><![CDATA[%s]]></FromUserName> 
                     <CreateTime>%s</CreateTime>
                     <MsgType><![CDATA[text]]></MsgType>
                     <Content><![CDATA[%s]]></Content>
                    <FuncFlag>0</FuncFlag>
                 </xml>";
    $resultStr = sprintf($retTmp,$fromusername,$tousername,time(),$regMsg);
    
    echo $resultStr;
    }
		
	public function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}