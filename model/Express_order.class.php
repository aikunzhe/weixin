<?php
require_once dirname(__FILE__).'/../connect/SingleTableOpera.php';
//必要文件
require_once dirname(__FILE__).'/../date/GlobalDefine.php';

class Express_order
{
    public function get_diqu()   //寄件人的地区
    {
        $sto = new SingleTableOpera("kd_dormitory",'DB');

        $args['_where']="school_id=1";
        $srr = $sto->getObject($args);
        return $srr;
    }
    public function get_express()    //快递名称
    {
        //引入数据库操作：
        $sto = new SingleTableOpera("kd_express",'DB');
        $args['_field']='id,name';
        $args['_where']="school_id=1";
        $srr = $sto->getObject($args);
        return $srr;
    }

    
    
    }

