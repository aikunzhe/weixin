<?php
/*
    ������Smarty��һЩ����
    ��Ϊ�������Щ������ظ�ʹ��
*/
                         
require_once dirname(__FILE__).'/../model/libs/Smarty.class.php'; 

        //����smarty ����
        $smarty = new Smarty();
        /*ģ���ļ�Ŀ¼*/
        $smarty->template_dir =dirname(__FILE__)."/../view/templates";
        /*�����ļ�Ŀ¼*/
        $smarty->compile_dir =dirname(__FILE__)."/../view/templates_c";
        /*�������ұ߽��*/
        $smarty->left_delimiter = "<{";
        $smarty->right_delimiter = "}>";
        //��������(�Լ��������)
        









