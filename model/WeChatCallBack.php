<?php
/**
 * 
 * wechat basic callback
 实现回复消息的封装
 * @author pacozhong
 *
 */
//include_once dirname(__FILE__).'/GlobalDefine.php';

class WeChatCallBack {
	protected $_postObject;
	protected $_fromUserName;//发送方帐号（一个OpenID） 
	protected $_toUserName;//开发者微信号 
	protected $_createTime;//消息创建时间 （整型） 
	protected $_msgType;//消息类型
	protected $_msgId;//消息id，64位整型 
	protected $_time;
	
    public function getToUserName() {
    	return $this->_toUserName;
    }
    //组装提示信息：HINT_TPL 在 ./GlobalDefine.php
    protected  function makeHint($hint) {
    	$resultStr = sprintf ( HINT_TPL, $this->_fromUserName, $this->_toUserName, $this->_time, 'text', $hint );
		return $resultStr;
    }
	
	public function init($postObj) {
		// 获取参数
		$this->_postObject = $postObj;
		if ($this->_postObject == false) {
			return false;
		}
		$this->_fromUserName = ( string ) trim ( $this->_postObject->FromUserName );
		$this->_toUserName = ( string ) trim ( $this->_postObject->ToUserName );
		$this->_msgType = ( string ) trim ( $this->_postObject->MsgType );
		$this->_createTime = ( int ) trim ( $this->_postObject->CreateTime );
		$this->_msgId = ( int ) trim ( $this->_postObject->MsgId );
		$this->_time = time ();
		if(!($this->_fromUserName && $this->_toUserName && $this->_msgType)) {
			return false;
		}
		return true;
	}
	
	public function process() {
		return $this->makeHint(HINT_NOT_IMPLEMEMT);
	}
	
    
   		
}