<?php
namespace app\controllers;

use yii\web\Controller;
use app\models\ROrderReportTask;
use yii\base\UserException;
class TestController extends Controller{
    
    public function actionIndex() {
        $statTask = new ROrderReportTask();
        
        $statTask->addError('2w34234', '你斯蒂芬斯蒂芬斯蒂芬');
        
        $errors = $statTask->getErrors();
        
        trigger_error(json_encode($errors));
        
        throw new UserException(json_encode($errors));
    }
    
    public function actionGo() {
    }
}

?>