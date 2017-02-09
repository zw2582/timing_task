<?php
namespace app\modules\supplier_v1;

use yii\base\Module;
/**
 * supplier task
 * @author zhouwei<wei.w.zhou@integle.com>
 * @copyright 2016年8月24日 上午10:12:12
 */
class ConsoleModule extends Module{
	
	public $controllerNamespace = 'app\modules\supplier_v1\commands';
	
	public function init(){
		parent::init();
	}
}