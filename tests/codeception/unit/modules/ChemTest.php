<?php
namespace tests\codeception\unit\modules;

use yii\codeception\TestCase;
use app\tools\ExcelTool;
use app\models\InvProchem;
use yii\log\Logger;
use app\tools\StringTool;
class ChemTest extends TestCase{
    
    public function testImport() {
        ini_set('date.timezone','Asia/Shanghai');
        $execData = ExcelTool::read('D:/Documents/Downloads/prochem_import.xls');
        array_shift($execData);
        foreach ($execData as $k=>$rowData) {
            if ($k == 2) {
                break;
            }
            $prochem = new InvProchem();
            //限量领用
            if(!empty($rowData[13]) && $rowData[13] != '否'){
                $val = $rowData[13];
                $limit_count = StringTool::findNum($val);
                if (strpos($val, '天') || strpos($val, '日')){
                    $limit_type = 1;
                }elseif (strpos($val, '周')){
                    $limit_type = 2;
                }elseif (strpos($val, '月')){
                    $limit_type = 3;
                }elseif (strpos($val, '季')){
                    $limit_type = 4;
                }elseif (strpos($val, '年')){
                    $limit_type = 5;
                }elseif (strpos($val, '次')){
                    $limit_type = 6;
                }else{
                    $limit_type = 0;
                }
                $prochem->limit_count = $limit_count;
                $prochem->limit_type = $limit_type;
            }
            //保质期
            $arrstr = explode('-', $rowData[14]);
            $shelflifestr = $arrstr[2].'-'.$arrstr[0].'-'.$arrstr[1];
            $prochem->shelf_life = strtotime($shelflifestr);
            
            \Yii::getLogger()->log($rowData, Logger::LEVEL_WARNING);
            \Yii::getLogger()->log($prochem->attributes, Logger::LEVEL_WARNING);
        }
    }
    
    public function testTiao() {
        require \Yii::$aliases['@app'].'/excel/PHPExcel/shared/Date.php';
        $str = '06-16-18';
        
        $arrstr = explode('-', $str);
        $str = $arrstr[2].'-'.$arrstr[0].'-'.$arrstr[1];
        
        
        codecept_debug(date("Y-m-d H:i:s",strtotime($str)));return;
        
//         $timestr = strtotime($str);
        $timestr = date("Y-m-d H:i:s", \PHPExcel_Shared_Date::ExcelToPHP($str));
        
        \Yii::getLogger()->log($timestr, Logger::LEVEL_WARNING);
    }
}