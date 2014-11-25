create table wx_ctoken(
    appId char(255) NOT NULL,
    token char(255) default null,
    expire int(11)  default null,
    addTimestamp int(11) default null
)default CHARACTER SET utf8 COLLATE utf8_general_ci;
//expire表示 access_token的有效期
//addTimestamp access_token的获取时间


AppID(应用ID)
wx219a2170161ff48a
AppSecret(应用密钥)
bb61ab89bc1ad99e2f608b71d186417a 隐藏 重置

更新了 
tokenStub.php 
GlobalDefine.php  
SingleTableOpera.php
doCurlRequest.php
抗纤维化


select d.*,e.name as ex_name from deal as d left join express as e on deal.express_id = express.id 














