<?php
    /*
    这个控制器：

    */
    require_once dirname(__FILE__).'/../control/Smarty_inculde.php';   
    require_once dirname(__FILE__).'/../model/Express_order.class.php';   
    
    $eo =  new Express_order();  
    $smarty->assign("dormitory", $eo->get_diqu());
    $smarty->assign("express",$eo->get_express());


    
    //header("Content-type: text/html;charset=utf-8");


    //导入数据        
    //  $smarty->assign("res2",$page_turn);// 这个用户收到的 信息   
   // $session=$_SESSION;
  //  $smarty->assign("user",$session['username']);   
    //指定用哪个模板，来显示
    $smarty->display('Express_order.tpl'); 
    exit; 





