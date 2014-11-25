<?php
require_once dirname(__FILE__).'/../connect/SingleTableOpera.php';
//必要文件
require_once dirname(__FILE__).'/../date/GlobalDefine.php';

//header("Content-type: text/html;charset=utf-8");
//引入smarty引擎
require_once dirname(__FILE__).'/../model/libs/Smarty.class.php';
//创建smarty 对象
$smarty = new Smarty();

/*设置左右边界符*/
$smarty->left_delimiter = "<{";
$smarty->right_delimiter = "}>";   

/*模板文件目录*/
$smarty->template_dir =dirname(__FILE__)."/templates";
/*编译文件目录*/
$smarty->compile_dir =dirname(__FILE__)."/templates_c";

//设置缓存信息
//$smarty->cache_dir = "./cache";
//$smarty->caching = true;
//$smarty->cache_lifetime = 15;


//引入数据库操作：
$sto = new SingleTableOpera("kd_dormitory",'DB');

$args['_where']="school_id=1";
$srr = $sto->getObject($args);

//分配数据到smarty对象
$smarty->assign("dormitory",$srr);

//引入数据库操作：
$sto = new SingleTableOpera("kd_express",'DB');
$args['_field']='id,name';
$args['_where']="school_id=1";
$srr = $sto->getObject($args);


//分配数据到smarty对象
$smarty->assign("express",$srr);






//指定用哪个模板，来显示
$smarty->display('Express_order.tpl');



