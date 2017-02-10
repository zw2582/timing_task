<?php
namespace app\commands;

use yii\console\Controller;
use app\models\Task;
use app\tools\StringTool;

/**
 * linux定时器定时运行的入库
 * @author zhouwei<wei.w.zhou@integle.com>
 * @copyright 2017年2月10日 下午5:13:35
 */
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
        /**
         * 1.获取需要执行或者需要检测的任务
         */
    	$inCount = Task::find()->where(['task_status' => self::ing, 'status' => 1])->count();
    	if ($inCount < $this->maxThread){
    		$task = Task::find()->where(['task_status' => [self::wait,self::ing], 'status'=>1])->orderBy('version ASC')->one();
    	} else {
    		$task = Task::find()->where(['task_status' => self::ing, 'status'=>1])->orderBy('audit_version ASC')->one();
    	}
    	
    	if (empty($task)){
    	    \Yii::trace('暂时没有任务执行，退出本次请求', __METHOD__);
    		$this->stdout('no task to exec');
    		return true;
    	}

    	/**
    	 * 2.判断该任务是需要执行，还是在执行中，
    	 * 如果再执行中，需要去检测执行是否已经终止，如果没有执行则生成进程号去执行该任务
    	 * 进程号的目的是用于避免多进程冲突
    	 */
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

    	/**
    	 * 3.根据任务类型找到任务执行路径，并运行返回执行结果
    	 */
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
