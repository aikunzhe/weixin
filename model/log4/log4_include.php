<?php
/*
    这个函数会把当前目录下的所有文件(包括子文件夹下的文件)
    require_once 一遍
    
*/

function autoLoad($currPath) {
            if (is_dir($currPath)) {
                $handler = opendir ($currPath);
                while (($filename = readdir( $handler )) !== false) {
                    if ($filename != "." && $filename != ".." && $filename[0] != '.') {		
                        if(is_file($currPath . '/' . $filename)) {		
                            require_once $currPath . '/' . $filename;
                           // echo "require_once $currPath . '/' . $filename<br>";
                        }
                        if(is_dir($currPath . '/' . $filename)) {		
                            $this->autoLoad($currPath . '/' . $filename);
                        }
                    }
                }
                closedir($handler);
            }
        }
        
        
autoLoad(dirname(__FILE__));









