<?php

/**
cURL 的get 操作 封装
 */
class doCurlRequest
{
   
        /**
         * @desc 封装curl的调用接口，get的请求方式
         */
public static function doCurlGetRequest($url, $data = array(), $timeout = 10) {
            if($url == "" || $timeout <= 0){
                return false;
            }
            if($data != array()) {
                $url = $url . '?' . http_build_query($data);	           //http_build_query使用给出的关联（或下标）数组生成一个经过 URL-encode 的请求字符串。
            }
            
            $con = curl_init((string)$url);
            curl_setopt($con, CURLOPT_HEADER, false);
            curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);

            return curl_exec($con);
        }

        /**
         * @desc 封装curl的调用接口，post的请求方式
         */
public static function doCurlPostRequest($url, $requestString, $timeout = 5) {   
            if($url == "" || $requestString == "" || $timeout <= 0){
                return false;
            }

            $con = curl_init((string)$url);
            curl_setopt($con, CURLOPT_HEADER, false);
            curl_setopt($con, CURLOPT_POSTFIELDS, $requestString);
            curl_setopt($con, CURLOPT_POST, true);
            curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);

            return curl_exec($con);
        }  
        /**
         * @desc 封装curl的调用接口，post https 的请求方式
         */
public static function doCurlPosthttpsRequest($url, $requestString, $timeout = 5) {   
            if($url == "" || $requestString == "" || $timeout <= 0){
                return false;
            }

            $con = curl_init((string)$url);
            curl_setopt($con, CURLOPT_HEADER, false);
            curl_setopt($con, CURLOPT_POSTFIELDS, $requestString);
            curl_setopt($con, CURLOPT_POST, true);
            curl_setopt($con, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($con, CURLOPT_TIMEOUT, (int)$timeout);
            curl_setopt($con,CURLOPT_SSL_VERIFYHOST,false);
            curl_setopt($con,CURLOPT_SSL_VERIFYPEER,false);
            return curl_exec($con);
        }  

    
    
    
    
    
        /**
         * @desc 封装curl的调用接口，Get Https的请求方式
         */    
public static function doCurlGetHttpsRequest($url,$data,$timeout=5){
            if($url==''||$timeout<=0)
            {return false;}
           //http_build_query使用给出的关联（或下标）数组生成一个经过 URL-encode 的请求字符串。 

      
        $url .='?'.http_build_query($data);

        $curl = curl_init();             
        
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_TIMEOUT,(int)$timeout);
        curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
    
        $str = curl_exec($curl);              
        curl_close($curl);
        return $str;
    }
}
