<?php

require_once dirname(__FILE__) . '/../date/GlobalDefine.php';
require_once dirname(__FILE__) . '/../connect/SingleTableOpera.php';

header("Content-type: text/html; charset=utf-8"); 

if(isset($_POST['getprovince']))//获取全部省份
{
        //接收数据
        $provinceid =$_POST['getprovince'];
        //数据库操作
        $sql = new SingleTableOpera('s_province','DB');
        $arr = array(
            '_field'=>'ProvinceID,ProvinceName ',
        );
        $result = $sql->getObject($arr);
        
        //构建返回数据
        echo  json_encode ( $result,JSON_UNESCAPED_UNICODE);
        return;
}else if(isset($_POST['getcity']))//获取XX市
{
        //接收数据
        $provinceid =$_POST['getcity'];
        //数据库操作
        $sql = new SingleTableOpera('s_city','DB');
        $arr = array(
            '_field'=>'CityID,CityName',
            '_where' => "ProvinceID = $provinceid",
        );
        $result = $sql->getObject($arr);
        
        //构建返回数据
        echo  json_encode ( $result,JSON_UNESCAPED_UNICODE);
        return;
} else if(isset($_POST['getcounty'])){   //获取XX区 县
            //接收数据
        $cityid =$_POST['getcounty'];
        //数据库操作
        $sql = new SingleTableOpera('s_district','DB');
        $arr = array(
            '_field'=>'DistrictID,DistrictName',
            '_where' => "CityID = $cityid",
        );
        $result = $sql->getObject($arr);
        
        //构建返回数据
       // echo $str = crateXML($result);
        echo  json_encode ( $result,JSON_UNESCAPED_UNICODE);
        return;
    
    
    }

exit;


