<?php
    /*
    �����������

    */
    require_once dirname(__FILE__).'/../control/Smarty_inculde.php';   
    require_once dirname(__FILE__).'/../model/Express_order.class.php';   
    
    $eo =  new Express_order();  
    $smarty->assign("dormitory", $eo->get_diqu());
    $smarty->assign("express",$eo->get_express());


    
    //header("Content-type: text/html;charset=utf-8");


    //��������        
    //  $smarty->assign("res2",$page_turn);// ����û��յ��� ��Ϣ   
   // $session=$_SESSION;
  //  $smarty->assign("user",$session['username']);   
    //ָ�����ĸ�ģ�壬����ʾ
    $smarty->display('Express_order.tpl'); 
    exit; 





