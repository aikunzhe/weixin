<?php /* Smarty version Smarty-3.1.21-dev, created on 2014-11-10 18:31:49
         compiled from "D:\xampp\htdocs\tp\view\templates\bookin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:575954607717353c92-74593202%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f7adc3d8df86e527b609e0780457c69efa468e0c' => 
    array (
      0 => 'D:\\xampp\\htdocs\\tp\\view\\templates\\bookin.tpl',
      1 => 1415615490,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '575954607717353c92-74593202',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_54607717386921_53936256',
  'variables' => 
  array (
    'dormitory' => 0,
    'tmp' => 0,
    'express' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54607717386921_53936256')) {function content_54607717386921_53936256($_smarty_tpl) {?><html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
</head>
<h1>订单提交</h1>
<form action="../control/deal_process.php" method="post">
用户名:<input type="text" name="user_name"/><br/>
手机长号：<input type="text" name="long_tel"/><br/>
手机短号：<input type="text" name="short_tel"/><br/>
取件时间：<select name="booked_time">
<option value="早上09:00-11:00">早上09:00-11:00</option>
<option value="中午12:00-14:00">中午12:00-14:00</option>
<option value="晚上19:00-22:00">晚上19:00-22:00</option>
</select><br/>

地区:<select name="dormitory_id">
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


寄往：<input type="text" name="send_to"/><br/>
物品重量:<input type="text" name="weight"/>KG<br/>



<input type="submit" value="提交"/>
</form>
</html>

<?php }} ?>
