<?php
require_once dirname(__FILE__).'/SingleTableOpera.php';
require_once dirname(__FILE__) . '/../model/WeChatCallBack.php';
/**
 * echo server implemention
 * @author pacozhong
 *
 */

class WeChatCallBackEchoServer extends WeChatCallBack{
    private $postObj;
    private $_eventtype;
	private $_eventKey;
	private $_content;
    
    public function init($postObj) { 
        $this->postObj = $postObj;
        if(false == parent::init($postObj)) {
            interface_log ( ERROR, EC_OTHER, "信息初始化失败!" );
            return false;
        }
       
        $this->_msgType=strtolower($this->_msgType);
         //收到的是自定义菜单的事件
        if($this->_msgType=='event')
        {
            $this->_eventtype = strtolower((string)$postObj->Event);
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

        
        //处理文本操作
        if ($this->_msgType == 'text')
        {
         //引入数据库操作：
        $sto = new SingleTableOpera("wx_test",'DB');
         //获取用户上次输入的操作的内容 对应表的input数据
               

               $args['_where'] = "id = ( select max(id) from wx_test where userId='{$this->_fromUserName}'and userAcction='text')";
               $rous = $sto->getObject($args);
               
               if(empty( $rous)==false)
               {echo $str =  $this->makeHint ($this->_postObject->Content." \n你上次输入的文字是:{$rous[0]['input']}"); 
               }
                        
            $arr = array(  //符合数据库的
            'userId'=>$this->_fromUserName,//发送方帐号
            'userAcction'=>$this->_msgType,//用户操作类型
            'input'=>$this->_postObject->Content,//消息内容       
            'addtime'=>$this->_createTime,//创建时间
            );  
           return $sto->addObject($arr);//调用插入方法
            
        }
       
        
        if($this->_msgType == 'event')//处理事件函数
        {
          
             
            if($this->_eventtype=='subscribe')// (订阅)
            {
             echo $str =  $this->makeHint ( "欢迎关注" );
             
             //将这个用户 登记到数据库(如果不存在)
             $sto = new SingleTableOpera("wx_user",'DB');           
             
             
            $where = array(
                '_where'=>"username={$this->_fromUserName}",        
            );
         
            $arr = array(  //符合数据库的
                'username'=>$this->_fromUserName,//发送方帐号
                'addTime'=>$this->_createTime,
            ); 
           
           $sto->addObjectIfNoExist($arr,$where);

             
             return  $str;

          
            }   
       
            if($this->_eventtype=='unsubscribe')// ((取消订阅) 
            {
/*              echo $str =  $this->makeHint ( "取消订阅成功" );
             
             //将这个用户 从到数据库消失
             $arr = array(  //符合数据库的
                'username'=>$this->_fromUserName,//发送方帐号
                ); 
             $sto = new SingleTableOpera("wx_user",'DB');
            $sto->delObject($arr);//调用插入方法
             
             return  $str; */

            }
            if($this->_eventtype=='click')// 点击按钮
            {               
                switch($this->_eventKey)
                {
                case 'SHUDANHAO':   
$input="ヽ(*。>Д<)o゜\n\r- 请点击键盘图标:\n\r- 直接输入单号即可！";
                        echo $str =  $this->makeHint ($input);   
                        break;        
                case  'SHOUKUAIDI':  
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
                'userAcction'=>$this->_msgType.'=>'.$this->_eventtype,//用户操作类型
                'input'=>$input,//消息内容       
                'addtime'=>$this->_createTime,//创建时间
                );    
                //引入数据库操作：
                $sto = new SingleTableOpera("wx_test",'DB');
                $sto->addObject($arr);//调用插入方法
                return  $str;   
            }
            if($this->_eventtype=='view')// ((自定义链接) 
            {
                $arr = array(  //符合数据库的
                'userId'=>$this->_fromUserName,//发送方帐号
                 'userAcction'=>$this->_msgType.'=>'.$this->_eventtype,//用户操作类型
                'input'=>$this->_eventKey,//消息内容       
                'addtime'=>$this->_createTime,//创建时间
                );    
                //引入数据库操作：
                $sto = new SingleTableOpera("wx_test",'DB');
                $sto->addObject($arr);//调用插入方法
                return  $str;   
            
            }
             if($this->_eventtype=='scancode_waitmsg')// 扫码推事件且弹出“消息接收中”提示框的事件推送  
            {
          list($type,$code) =explode(",",$this->postObj->ScanCodeInfo->ScanResult);  
                
echo $str =  $this->makeHint ( "你的扫码结果是：{$code},类型是{$type}" );

            }
            // echo $str =  $this->makeHint ( "你发送的消息类型是{$this->_msgType}" );
            //   return  $str;

            
        }
  
     // echo $str =  $this->makeHint ( "你发送的消息类型是{$this->_msgType}还有{$this->_eventtype}" );
    // return  $str;
   
    }
		
}
