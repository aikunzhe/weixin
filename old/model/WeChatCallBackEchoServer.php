<?php
require_once dirname(__FILE__) . '/WeChatCallBack.php';
require_once dirname(__FILE__).'/SingleTableOpera.php';
/**
 * echo server implemention
 * @author pacozhong
 *
 */

class WeChatCallBackEchoServer extends WeChatCallBack{
    private $_event;
	private $_eventKey;
	private $_content;
    
    public function init($postObj) { 
        if(false == parent::init($postObj)) {
            interface_log ( ERROR, EC_OTHER, "init fail!" );
            return false;
        }
        //收到的是自定义菜单的事件的时候。
        $this->_msgType=strtolower($this->_msgType);
        if($this->_msgType=='event')
        {
            $this->_event = (string)$postObj->Event;
            $this->_eventKey = (string)$postObj->EventKey;
        }
       //收到的是文本消息。
        if($this->_msgType=='text')
        {
            $this->_content = (string)$postObj->Content;
        }
        return true;
 
    }
    
	public function process(){   
          $this->_event=strtolower($this->_event);  
		if(! ($this->_msgType == 'text'||$this->_msgType == 'event'&&$this->_event=='click')) {
          echo $str =  $this->makeHint ( "你发的不是文字或者你发送的不是菜单消息" );
           return  $str;
		}
        //引入数据库操作：
        $sto = new SingleTableOpera("wx_test",'DB');
        
        if($this->_msgType == 'event')//处理事件函数
        {
            switch($this->_eventKey)
            {
            case 'V1001_TODAY_MUSIC':   
                    $input='我要寄件';
                    echo $str =  $this->makeHint ($input);   
                    break;        
            case  'V1001_TODAY_SINGER':  
                    $input='我要收件';
                    echo $str =  $this->makeHint ($input);   
                    break;        
            case  'V1001_HELLO_WORLD':  
                    $input='hello world';
                    echo $str =  $this->makeHint ($input);   
                    break;        
            case 'V1001_GOOD':    
                    $input='赞一下我们';
                    echo $str =  $this->makeHint ($input);   
                    break;            
            }   
            $arr = array(  //符合数据库的
            'userId'=>$this->_fromUserName,//发送方帐号
            'userAcction'=>$this->_msgType,//用户操作类型
            'input'=>$input,//消息内容       
            'addtime'=>$this->_createTime,//创建时间
            );          
        }else//处理文本操作
        {
           //获取用户上次输入的操作的内容 对应表的input数据
           

           $args['_where'] = "id = ( select max(id) from wx_test where userId='{$this->_fromUserName}'and userAcction='text')";
           $rous = $sto->getObject($args);
           
           
         echo $str =  $this->makeHint ($this->_postObject->Content." \n你上次输入的数据是:{$rous[0]['input']}");            
        $arr = array(  //符合数据库的
        'userId'=>$this->_fromUserName,//发送方帐号
        'userAcction'=>$this->_msgType,//用户操作类型
        'input'=>$this->_postObject->Content,//消息内容       
        'addtime'=>$this->_createTime,//创建时间
        );           
        }
  

        $sto->addObject($arr);//调用插入方法
        return  $str;  

        
        
        
        
/* 		try {
			$db = DbFactory::getInstance('ES');
			$sql = "insert into userinput (userId, input) values(\"" . $this->_fromUserName . "\", \"" . $this->_postObject->Content . "\")";
			interface_log(DEBUG, 0, "sql:" . $sql);			
			$db->query($sql);
			$STO = new SingleTableOperation("userinput", "ES");
			$ret = $STO->getObject(array("userId" => $this->_fromUserName));
			$out = "";
			foreach ($ret as $item) {
				$out .= $item['input'] . ", ";
			}
		} catch (DB_Exception $e) {
			interface_log(ERROR, EC_DB_OP_EXCEPTION, "query db error" . $e->getMessage());
		}
		return $this->makeHint ($out); */

        
	}	
}
