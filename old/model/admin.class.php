<?php
require_once 'SqlHelper.class.php';
//
class admin
{
    function show_all()
    {
      $str = "select * from kd_adm0in";
      $sql = new SqlHelper('DB');
      if($sql->connect()==false)
      { 
        echo "有错<br>";  
      }
      
      return $sql->execute_dql_arry($str);

      
    }



	
}



?>