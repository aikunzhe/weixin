<?php /* Smarty version Smarty-3.1.21-dev, created on 2014-11-21 22:06:18
         compiled from "D:\xampp\htdocs\weixin\view\templates\Express_order.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17199546f219e8cc4a4-27851171%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '66642b0796909cd642d0de99c633d93dcd6d46a7' => 
    array (
      0 => 'D:\\xampp\\htdocs\\weixin\\view\\templates\\Express_order.tpl',
      1 => 1416578775,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17199546f219e8cc4a4-27851171',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_546f219e925315_26130569',
  'variables' => 
  array (
    'dormitory' => 0,
    'tmp' => 0,
    'express' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_546f219e925315_26130569')) {function content_546f219e925315_26130569($_smarty_tpl) {?><html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<?php echo '<script'; ?>
 type="text/javascript" src='../view/templates/my.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript">
		
		function getCities(e,cityid)
		{       
        //根据传入的值 确定使用的参数
        if(cityid=="getprovince")        {       
            var data = "getprovince=*&&t=" + Math.random();	//发送的请求数据
            var re_city = $('province');//请求回来的数据 使用对应的控件显示

        }else if(cityid=="getcity")        {
            $('city').options.length=1;
            $('city').options[0].text="--城市--";
             $('county').options.length=1;
            $('county').options[0].text="--县城--";         
            if(e.value=='') return;
            var data = "getcity="+e.value+"&&t=" + Math.random();	
            var re_city = $('city');        
        }else if(cityid=="getcounty")        {
               $('county').options.length=1;
            $('county').options[0].text="--县城--";         
            if(e.value=='') return;
            var data = "getcounty="+e.value+"&&t=" + Math.random();	
            var re_city = $('county');

        }else         {
         return;
        }

        
		var myxmlhttprequest = getXmlHttpObject();
		//向服务器发送请求
		//为了避免可能得到的是缓存的结果，请向 URL 添加一个唯一的 ID：
		var url="../control/cityProcess.php"
		//var data = $(cityid).id+"="+$(cityid).value+"&&t=" + Math.random();	
		//打开请求
		//method：请求的类型；GET 或 POST 
		//url：文件在服务器上的位置 
		//async：true（异步）或 false（同步） 		
		myxmlhttprequest.open("post",url,true);
		//发送请求

		myxmlhttprequest.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		myxmlhttprequest.send(data);
		//指定回调函数 
		myxmlhttprequest.onreadystatechange=function()
		{
			if (myxmlhttprequest.readyState==4 && myxmlhttprequest.status==200)
			{
            
            var cities = eval("("+myxmlhttprequest.responseText+")");
						//$('myres').innerHTML = res.msg;
           // alert(cities.length);
             //输出第一个city元素的 第一个 第二个 子元素的内容         
            
  
              //把返回的城市动态添加到city控件
                var city = re_city;
                //清空一下select
				//city.options.length=0;
                var i=0;
                var j=0;
                var tmp_conut;
                var tmp_array= [1,2];
                for(i=0;i<cities.length;i++)
                { 
                tmp_conut=0;
                  for(j in cities[i])
                  { 
                       // alert(  cities[i][j]);
                       tmp_array[tmp_conut++] =  cities[i][j];  
                        //alert( tmp_array[tmp_conut-1]);
                  }
                 // alert(tmp_array[0],tmp_array[1]);
                city.options[i+1]=new Option(tmp_array[1],tmp_array[0]);            
                }
                
			}
		}	
    }
        
        
<?php echo '</script'; ?>
>

</head>
<body onload="getCities(this,'getprovince');">
<h1>订单提交</h1>
<form action="../control/Express_order_Control.php" method="post">
<h3>寄件人信息</h3>
寄件人名字:<input type="text" name="user_name"/><br/>
联系方式:<br/>
手机长号：<input type="text" name="long_tel"/><br/>
手机短号：<input type="text" name="short_tel"/><br/>
所在地区:<select name="dormitory_id">
<?php  $_smarty_tpl->tpl_vars['tmp'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tmp']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dormitory']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tmp']->key => $_smarty_tpl->tpl_vars['tmp']->value) {
$_smarty_tpl->tpl_vars['tmp']->_loop = true;
?>
<option value="<?php echo $_smarty_tpl->tpl_vars['tmp']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['tmp']->value['name'];?>
</option>
<?php } ?>
</select><br/>
宿舍号：<input type="text" name="address"/><br/>


取件时间：<select name="booked_time">
<option value="早上09:00-11:00">早上09:00-11:00</option>
<option value="中午12:00-14:00">中午12:00-14:00</option>
<option value="晚上19:00-22:00">晚上19:00-22:00</option>
</select><br/>

<h3>快件信息</h3>

选择快递<select name="express_id">
<?php  $_smarty_tpl->tpl_vars['tmp'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tmp']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['express']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tmp']->key => $_smarty_tpl->tpl_vars['tmp']->value) {
$_smarty_tpl->tpl_vars['tmp']->_loop = true;
?>
<option value="<?php echo $_smarty_tpl->tpl_vars['tmp']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['tmp']->value['name'];?>
</option>
<?php } ?>
</select><br/>


寄往地区：
    <select id="province" name="province" onchange="getCities(this,'getcity');">
    <option value="" selected="">---省---</option>
    </select>
    <select id="city" name="city" onchange="getCities(this,'getcounty');">
    <option value="" selected="">--城市--</option>
    </select>
     <select id="county" name="county" onchange="getCities(this,'getnext');">
    <option value="" selected="">--县城--</option>
    </select><br/>
详细地址:<input type="text" name="send_to"/><br/>
物品重量:<input type="text" name="weight"/>KG<br/>
备注:<input type="text" name="note"/><br/>


<input type="submit" value="提交"/>
</form>
</body>
</html>

<?php }} ?>
