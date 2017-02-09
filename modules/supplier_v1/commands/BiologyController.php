<?php
namespace app\modules\supplier_v1\commands; 

use app\modules\supplier_v1\core\CsvController;
use app\modules\supplier_v1\models\BiologyForm;
use app\models\SPackageUnit;
/**
 * product_biology csv import
 * @author zhouwei<wei.w.zhou@integle.com>
 * @copyright 2016-6-24 下午4:08:47
 */
class BiologyController extends CsvController {
    
    //public $keys = ['number','cas','ics','brand','cn_name','en_name','description','website',
//        'purity','package_count','package_unit_id','price','inventory_status','stock_time',
//        'delivery_time','promotion'];
    public $keys = ['number','brand','cn_name','en_name','description','website','package','tstg',
        'price','inventory_status','stock_time','promotion','promotion_tag'];
    
    public $userId;
    
    public $supplierId;
    
    public $missionId;
    
    public $cn_units;
    
    public $en_units;
    
    public function beforeRun() {
        $this->userId = $this->mission->user_id;
        $this->supplierId = $this->mission->supplier_id;
        $this->missionId = $this->mission->id;
        $unitList = SPackageUnit::find()->where(['product_type'=>[0, 2], 'status'=>1])->asArray()->all();
        $this->cn_units = array_column($unitList, 'id', 'cn_name');
        $this->en_units = array_column($unitList, 'id', 'en_name');
    }
    
    /**
     * (non-PHPdoc)
     * @see \app\modules\supplier_v1\core\CsvController::fetCall()
     */
    public function fetCall($data) {        
        if (!in_array($data['inventory_status'], ['现货','期货'])) {
            return '库存状态请在“现货”或者“期货”中选择';
        }
        $data['inventory_status'] = str_replace(['现货','期货'], [1,2], $data['inventory_status']);
        $data['promotion'] = str_replace(['','是','否'], [1,1,0], $data['promotion']);
        $biologyForm = new BiologyForm();
        if (!$biologyForm->save($this->userId, $this->supplierId, $data, $this->missionId)) {
            return current($biologyForm->getFirstErrors());
        }
    }
    
}