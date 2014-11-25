<?php
//必要文件
include_once dirname(__FILE__).'/../date/GlobalDefine.php';
require_once dirname(__FILE__).'/../connect/menuStub.php';

//引入日志 函数 非类
require_once dirname(__FILE__).'/../model/log4/log4_include.php';



interface_log(DEBUG, 0, "***start menu 菜单**");
$menuData = array(
	'button'=>array(
		array(
			'type' => 'view',
			'name' => '我要寄件',
			'url' => 'http://182.92.97.249/control/Express_order_UI_Control.php'
		),
		array(
			'name' => '查收快件',
            'sub_button' => array(
				array(
					'type' => 'click',
					'name' => '输单号',
					'key' => 'SHUDANHAO',
				),
				array(
					'type' => 'scancode_waitmsg',
					'name' => '扫描条码',
					'key' => 'scancode_waitmsg',
				),
            )
        ),
		array(
			'name' => "我",
			'sub_button' => array(
				array(
					'type' => 'click',
					'name' => '我的快递',
					'key' => 'V1001_HELLO_WORLD'
				),
                array(
					'type' => 'click',
					'name' => '客户端下载',
					'key' => 'client_down',
				),
				array(
					'type' => 'click',
					'name' => '快递官网',
					'key' => 'official_website',
				),
			),
		)
 )
);

$ret = menuStub::create('ES', $menuData);
if(false === $ret) {
	interface_log(DEBUG, 0, "create menu fail!");
	echo "create menu fail!\n";
} else {
	interface_log(DEBUG, 0, "creat menu success");
	echo "create menu success!\n";
}
interface_log(DEBUG, 0, "***end menu***");


