<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
</head>
<h1>订单提交</h1>
<form action="../control/deal_process.php" method="post">
用户名:<input type="text" name="user_name"/><br/>
手机长号：<input type="text" name="long_tel"/><br/>
手机短号：<input type="text" name="short_tel"/><br/>
取件时间：<select name="booked_time">
<option value="早上09:00-11:00">早上09:00-11:00</option>
<option value="中午12:00-14:00">中午12:00-14:00</option>
<option value="晚上19:00-22:00">晚上19:00-22:00</option>
</select><br/>

地区:<select name="dormitory_id">
<{foreach $dormitory as $tmp}>
<option value="<{$tmp['id']}>"><{$tmp['name']}></option>
<{/foreach}>
</select><br/>
宿舍号：<input type="text" name="address"/><br/>

选择快递<select name="express_id">
<{foreach $express as $tmp}>
<option value="<{$tmp['id']}>"><{$tmp['name']}></option>
<{/foreach}>
</select><br/>


寄往：<input type="text" name="send_to"/><br/>
物品重量:<input type="text" name="weight"/>KG<br/>



<input type="submit" value="提交"/>
</form>
</html>

