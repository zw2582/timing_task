<?php
namespace app\commands;

use yii\console\Controller;
use app\models\Task;
use app\tools\StringTool;

class HelloController extends Controller
{
	const wait = 1;
	const ing = 2;
	const comple = 3;
	const interrupt = 4;   //中断
	const other = 10;
	private $maxThread = 3;
	const maxVersion = 5;
	
    public function actionIndex() {
    	$inCount = Task::find()->where(['task_status' => self::ing, 'status' => 1])->count();
    	if ($inCount < $this->maxThread){
    		$task = Task::find()->where(['task_status' => [self::wait,self::ing], 'status'=>1])->orderBy('version ASC')->one();
    	} else {
    		$task = Task::find()->where(['task_status' => self::ing, 'status'=>1])->orderBy('audit_version ASC')->one();
    	}
    	
    	if (empty($task)){
    		$this->stdout('no task to exec');
    		return true;
    	}

    	$thread_no = '';
    	if ($task->task_status == self::wait){
    	    if ($task->version < 127) {
    	        $task->version = $task->version + 1;
    	    }
    	    
    	    $thread_no = StringTool::guid();
    		$task->task_status = self::ing;
    		$task->thread_no = $thread_no;
    		$task->begin_time = time();
    	}
    	$task->audit_version = time();
    	
    	if (!$task->save()){
    	    \Yii::error(current($task->getFirstErrors()));
    		return false;
    	}

    	\Yii::$app->requestedParams = ['task_id'=>$task->id, 'thread_no'=>$thread_no, 'task_version'=>$task->version];
    	if (empty(\Yii::$app->params['exec_path'][$task->type_id])){
    	    \Yii::error('没有在配置文件中找到任务执行路径，task_id:'.$task->id);
    	    return false;
    	}

    	$result = $this->run(\Yii::$app->params['exec_path'][$task->type_id]);

    	if (in_array($result, array(self::comple, self::wait, self::interrupt))){
    	    $task->task_status = $result;
    	    if ($task->task_status == self::comple) {
    	        $task->end_time = time();
    	    }
    		if (!$task->save()){
    		    \Yii::error('修改任务状态失败，task_id:'.$task->id.','.current($task->getFirstErrors()));
    			return false;
    		}
    	}
    	
    	$this->stdout($result);
    }
    
}
