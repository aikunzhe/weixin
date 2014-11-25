<?php

/*
email  规则
1.@前面可以是 字母 数字 下划线 但必须字幕开头
2.@后面可以是 126.net.cn 这样的由数字和字母组合的


*/
function smarty_modifier_isemail($string)
{           
       // $string="z12z3@126.com.cn.as.ad";
        $parrent='/^([a-zA-Z])([\w]*?)@([a-zA-Z0-9]*?)(\.[a-zA-Z0-9]+)+$/i';
 

        
        
        if(preg_match($parrent,$string,$arr)==1)
        { 
                echo "是邮箱";
        
           
        }
        else{
                echo  "不是邮箱";
         
        }
       // echo "<pre>";
        //print_r($arr);
} 