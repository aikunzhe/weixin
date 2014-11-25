<?php
header("content-type:text/html;charset=utf-8");
require_once "page.class.php";
require_once "SqlHelper.class.php";


$pageSize=5;//多少行
$uri='control.php';//设置分页导航条 跳转的页面
$page_whole=10;//分页导航条 显示 1,2,3,4,5，
//当前页面
if ( isset ( $_GET ['pagenow'] )) {
    $pageNow = $_GET ['pagenow'];
}else{
    $pageNow=1;
}
$page = new page($pageSize,$pageNow,$uri,$page_whole);
$page->is_right();//防止pageNow 是垃圾数据
$sqlhelper = new SqlHelper();
//根据 pageNow  pageSize 获取数据
$sql1="select * from `songinfo`  limit ".($page->pageNow-1)*$page->pageSize.",".$page->pageSize;
$sql2="select count(`song_id`) as `count`   from `songinfo`";
$sqlhelper->execute_dql_fenye($sql1, $sql2, $page);

	$page->is_right();//防止pageNow 是一个比最大页数 还大的数字
	{//数据不合法 就要重新制作sql查询语句
        $sql1="select * from `songinfo`  limit ".($page->pageNow-1)*$page->pageSize.",".$page->pageSize;
        $sql2="select count(`song_id`) as `count`   from `songinfo`";

        $sqlhelper->execute_dql_fenye($sql1, $sql2, $page);
	}




 //这个表示 分页的数据
 $res2 = $page->res_array;

 
 //打印表头
echo "<table class='gridtable gridtable-search' border=1><tr>";
foreach ( $res2[0] as $key=>$value )
{
    echo "<th>$key</th>";
}
echo "</tr>";
//打印数据
 foreach ( $res2 as $arr1)
{   
    echo "<tr>";
   $i=1;  
    foreach ($arr1 as $value )
    {
   
         if( $i==6||$i==0)
        {  
            echo "<td><img src='$value'></td>";		
        }
        else
        {
           echo "<td>{$value}</td>";
        }
     
        $i++;
    }
    echo "</tr>";
}
echo "</table>";
//导航条
echo $page->nativgate();
?>        
