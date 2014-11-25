<?php

require_once dirname(__FILE__).'/../connect/SingleTableOpera.php';
//必要文件
require_once dirname(__FILE__).'/../date/GlobalDefine.php';
//引入日志 函数 非类
require_once dirname(__FILE__).'/../model/log4/log4_include.php';
header("Content-type: text/html;charset=utf-8");

$post=$_POST; 
$sendto="";
 //处理城市
 if(isset($post['province']))//获取全部省份
{
        //接收数据
        $provinceid =$post['province'];
        //数据库操作
        $sql = new SingleTableOpera('s_province','DB');
        $arr = array(
            '_field'=>'ProvinceName',
            '_where' => "ProvinceID = $provinceid",
        );
        $result = $sql->getObject($arr);
       $sendto.=  $result[0]['ProvinceName'];

}
 if(isset($post['city']))//获取XX市
{
        //接收数据
        $cityid =$post['city'];
        //数据库操作
        $sql = new SingleTableOpera('s_city','DB');
        $arr = array(
            '_field'=>'CityName',
            '_where' => "CityID = $cityid",
        );
        $result = $sql->getObject($arr);
       
  $sendto.=  $result[0]['CityName'];
} 

if(isset($post['county'])){   //获取XX区 县
            //接收数据
        $countyid =$post['county'];
        //数据库操作
        $sql = new SingleTableOpera('s_district','DB');
        $arr = array(
            '_field'=>'DistrictName',
            '_where' => "DistrictID = $countyid",
        );
        $result = $sql->getObject($arr);
          $sendto.=  $result[0]['DistrictName'];

    }
 
 //echo"$sendto";
 //exit; sendto 制作完成

$sto = new SingleTableOpera("kd_deal",'DB');


 $arr = array(
'deal_code'=>strtoupper(uniqid()),         // 订单号	
'create_date' 	=>  date("Y-m-d H:i:s"),// 这个订单 创建时间
'booked_time'	=>$post['booked_time'],
'success_date' 	=> 0,
'long_tel' 	=>$post['long_tel'],
'short_tel' =>	$post['short_tel'],
'user_name' =>	$post['user_name'],
'user_ip' 	=>0,
'school_id' =>	1,
'dormitory_id' =>  	$post['dormitory_id'],
'address' 	=>$post['address'],
'su_id' 	=> 0,
'su_level' 	=>0,
'send_to' 	=>$sendto,
'weight' 	=>$post['weight'],
'income' 	=>10,
'express_id' =>$post['express_id'],
'express_code' =>	0,
'other_express' =>	0,
'status'	=>1,
'tag' 	=>0,
'remove'=>0
 );  
 //echo "<pre>";
 //print_r( $arr);
 //exit;
$is = $sto->addObject($arr);

if($is==1){        
    echo"提交订单成功";
}
else
{
    echo"提交订单不成功";       
}
 
