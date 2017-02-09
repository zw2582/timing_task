<?php
namespace app\tools;

/**
 * 字符串工具
 * @author zhouwei<wei.w.zhou@integle.com>
 * @copyright 2016-4-5 上午11:18:57
 */
class StringTool {
	
	/**
	 * 生成GUID
	 * @author zhouwei<wei.w.zhou@integle.com>
	 * @return string
	 * @copyright 2016-4-5 上午11:19:07
	 */
	public static function guid(){
		if (function_exists('com_create_guid')){
			return com_create_guid();
		}else{
			mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
			$charid = strtoupper(md5(uniqid(rand(), true)));
			$hyphen = chr(45);// "-"
			$uuid = chr(123)// "{"
			.substr($charid, 0, 8).$hyphen
			.substr($charid, 8, 4).$hyphen
			.substr($charid,12, 4).$hyphen
			.substr($charid,16, 4).$hyphen
			.substr($charid,20,12)
			.chr(125);// "}"
			return $uuid;
		}
	}
	
	
	/**提取字符串中的数字*/
	public static function findNum($str=''){
	    $str=trim($str);
	    if(empty($str)){return '';}
	    $result='';
	    for($i=0;$i<strlen($str);$i++){
	        if(is_numeric($str[$i])){
	            $result.=$str[$i];
	        }
	    }
	    return $result;
	}
	
}
