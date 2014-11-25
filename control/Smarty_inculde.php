<?php
/*
    这个存放Smarty的一些定义
    因为下面的这些定义会重复使用
*/
                         
require_once dirname(__FILE__).'/../model/libs/Smarty.class.php'; 

        //创建smarty 对象
        $smarty = new Smarty();
        /*模板文件目录*/
        $smarty->template_dir =dirname(__FILE__)."/../view/templates";
        /*编译文件目录*/
        $smarty->compile_dir =dirname(__FILE__)."/../view/templates_c";
        /*设置左右边界符*/
        $smarty->left_delimiter = "<{";
        $smarty->right_delimiter = "}>";
        //导入数据(自己另行添加)
        









