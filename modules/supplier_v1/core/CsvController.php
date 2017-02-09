<?php
namespace app\modules\supplier_v1\core;

use yii\console\Controller;
use app\models\SMission;
use app\commands\HelloController;
use app\models\SMissionError;
use app\models\Task;
/**
 * 
 * @author zhouwei<wei.w.zhou@integle.com>
 * @copyright 2016-6-24 下午3:13:13
 */
class CsvController extends Controller {
    
    public $thread_no ;
    public $taskId ;
    public $mission;
    public $keys;  //用于将读取出来的索引数组替换成关联数组的下标键
    
    public function init() {
        parent::init();
    }
    
    /**
     * csv import
     * @author zhouwei<wei.w.zhou@integle.com>
     * @return number|string|number
     * @copyright 2016年8月24日 上午10:14:04
     */
    public function actionImport() {
        $this->thread_no = \Yii::$app->requestedParams['thread_no'];
        $this->taskId = \Yii::$app->requestedParams['task_id'];
        $task_version = \Yii::$app->requestedParams['task_version'];
        
        //1.检查队列是否存在
        $this->mission = SMission::findOne(['task_id'=>$this->taskId, 'status'=>1]);
        $mission = &$this->mission;
        if (empty($mission)){
            return HelloController::comple;
        }

        if ($task_version >= HelloController::maxVersion) {
            \Yii::error('供应商任务执行很多次后失败了，mission_id:'.$mission->id);
            SMissionError::log($mission->id, 0, '文件解析发生内部错误，请联系管理员');
            return HelloController::comple;
        }
        if (empty($this->thread_no)){
            if ($mission->audit_line == $mission->line){
                return HelloController::wait;
            }
            $mission->audit_line = $mission->line;
            $mission->save();
            return HelloController::other;
        } else {
            $mission->thread_no = $this->thread_no;
            $mission->save();
        }

        if (!$this->filter()) {
            return HelloController::comple;
        }
        
        $this->beforeRun();
        
        return $this->fetCsv();
    }
    
    /**
     * 拦截器
     * @author zhouwei<wei.w.zhou@integle.com>
     * @return boolean
     * @copyright 2016-6-25 下午12:02:37
     */
    protected function filter() {
        $mission = &$this->mission;
        if (empty($mission->deep_path) || empty($mission->save_name)) {
            SMissionError::log($mission->id, 0, '上传文件已失效');
            return FALSE;
        }
        return TRUE;
    }
    
    /**
     * 校验，该检验如果返回false，将会是任务失败
     * @author zhouwei<wei.w.zhou@integle.com>
     * @copyright 2016-6-24 下午3:57:05
     */
    protected function beforeRun() {
        
    }
    
    /**
     * 读取csv文件
     * @author zhouwei<wei.w.zhou@integle.com>
     * @copyright 2016-6-24 下午4:05:04
     */
    public function fetCsv() {
        $mission = &$this->mission;
        $deep_path = $mission->deep_path;
        $save_name = $mission->save_name;
        $filePath = UPLOADS_PATH.'files'.DS.$deep_path.DS.$save_name;
        
        if(!is_file($filePath)){
            SMissionError::log($mission->id, 0, '文件不存在');
            return HelloController::comple;
        }
        
        $spl_object = new \SplFileObject($filePath, 'rb');
        //1.设置总数
        if ($mission->line == 0 || $mission->line == 1) {
            $spl_object->seek(filesize($filePath));
            $mission->line = 0; //这里之所以这样设置，是因为$spl_object->seek(1);并不会读取第二行的数据，而是读第三行的数据
            $mission->total_line = $spl_object->key();
            $mission->save();
        }
        
        //2.设置起始位置
        $start = $mission->line;
        $spl_object->seek($start);
        while (!$spl_object->eof()) {
            $start++;
            //判断程序是否中断
            $task = Task::findOne($this->taskId);
            if (empty($task) || !$task->status || $task['task_status'] == HelloController::comple) {
                return HelloController::comple;
            }
            $mission = SMission::findOne($mission->id);
            if (empty($mission) || $mission->status == 0) {
                return HelloController::interrupt;
            }
            if ($mission->thread_no != $this->thread_no) {
                return HelloController::other;
            }
            
            $data = $spl_object->fgetcsv();
            if (empty(array_filter($data))) {
                return HelloController::comple;
            }
            
            $data = $this->array_iconv('GBK', 'UTF-8', $data);
            $sliceKeys = array_slice($this->keys, 0, count($data));
            $keyData = array_combine($sliceKeys, $data);
            if ($start != 1) {
                //运行数据处理器
                $result = $this->fetCall($keyData);
                //如果返回字符串，则表明错误
                if (is_string($result)) {
                    SMissionError::log($mission->id, $start, $result, json_encode($keyData));
                } else {
                    SMission::updateAllCounters(['success_line'=>1], ['id'=>$mission->id]);
                }
            }

            //记录执行到的行数
            SMission::updateAllCounters(['line'=>1], ['id'=>$mission->id]);
        }
        
        $mission->handle_status = 2;
        if ($mission->save()){
            $this->afterComplete();
            return HelloController::comple;
        }
    }
    
    protected function afterComplete() {
        
    }
    
    /**
     * 读取csv文件的某一行的回调程序
     * @author zhouwei<wei.w.zhou@integle.com>
     * @copyright 2016-6-24 下午4:05:36
     */
    protected function fetCall($data){
        \Yii::trace('父类开始上传','user');
    }
    
    function array_iconv($in_charset,$out_charset,$arr){
        foreach ($arr as $key => $value) {
            if(is_string($key)){
                $key=iconv($in_charset,$out_charset.'//IGNORE',$key);
            }
            if(is_string($value)){
                $value=iconv($in_charset,$out_charset.'//IGNORE',$value);
            }
            $rtn[$key]=trim($value);
        }
        return $rtn;
        //2016年8月2日忽略
        return eval('return '.iconv($in_charset,$out_charset,var_export($arr,true).';'));
    }
    
}