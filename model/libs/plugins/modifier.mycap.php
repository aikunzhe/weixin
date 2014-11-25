<?php
/*
取出首字母

*/



    function smarty_modifier_mycap($string)
    {
        $str="";
       
        
       $str.=strtoupper(substr($string,0,1));//首字母大写
       $str.=strtolower(substr($string,1));//其他字幕小写
       return $str;
    
    }