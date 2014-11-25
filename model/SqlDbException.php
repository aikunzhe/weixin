<?php

/**
 * 数据库操作异常类
 * @desc: 
 *
 * @author 
 * @version v1.0.0
 * @package common
 */

class DB_Exception extends Exception {
            
     public function __construct($str) {
          interface_log(ERROR, EC_OTHER, $str);
         // echo $str;
        }


}

