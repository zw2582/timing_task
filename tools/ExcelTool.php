<?php
namespace app\tools;

class ExcelTool {
	
	public static function read($excelPath, $sheet = 0) {
		//读取Excel文件
		require_once dirname(dirname(__FILE__)).'/excel/PHPExcel.php';
		require_once dirname(dirname(__FILE__)).'/excel/PHPExcel/IOFactory.php';
		require_once dirname(dirname(__FILE__)).'/excel/PHPExcel/CachedObjectStorageFactory.php';
		 
		$cacheMethod = \PHPExcel_CachedObjectStorageFactory::cache_in_memory_serialized;
		$cacheSettings = array();
		\PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
		 
		$excel = \PHPExcel_IOFactory::load($excelPath);
		/**读取excel文件中的第一个工作表*/
		$currentSheet = $excel->getSheet($sheet);
		$data = $currentSheet->toArray();
		return $data;
	}
}