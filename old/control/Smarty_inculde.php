<?php
/*
    ������Smarty��һЩ����
    ��Ϊ�������Щ������ظ�ʹ��
*/
require_once '../libs/Smarty.class.php';                            
    
        //����smarty ����
        $smarty = new Smarty();
        /*ģ���ļ�Ŀ¼*/
        $smarty->template_dir ="../templates";
        /*�����ļ�Ŀ¼*/
        $smarty->compile_dir ="../templates_c";
        /*�������ұ߽��*/
        $smarty->left_delimiter = "<{";
        $smarty->right_delimiter = "}>";
        //��������










