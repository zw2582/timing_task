<?php
namespace app\controllers;


use app\models\Task;
class TaskController extends Web_Controller {
	
	
	const wait = 1;
	const ing = 2;
	const comple = 3;
	
	/**
	 * 新增任务
	 * @author zhouwei<wei.w.zhou@integle.com>
	 * @copyright 2016-4-5 上午10:51:09
	 */
	public function actionAdd(){
		$typeId = $this->getParam('type_id', 0);
		if (!in_array($typeId, [TASK_INV_PRO_IMPORT])){
			return $this->ajaxFail('参数不对');
		}
		$task = new Task();
		$task->type_id = $typeId;
		if (!$task->save()){
			return $this->ajaxFail(array_values($task->getFirstErrors())[0]);
		}
		return $this->ajaxSucc('获取成功', $task->attributes);
	}
	
	/**
	 * 获取任务
	 * @author zhouwei<wei.w.zhou@integle.com>
	 * @return multitype:|Ambigous <\yii\db\static, NULL, multitype:, boolean, \yii\db\ActiveRecord>
	 * @copyright 2016-4-5 上午10:53:32
	 */
	public function actionGet(){
		$taskId = $this->getParam('task_id', 0);
		$task = Task::findOne($taskId);
		if(!empty($task)){
			return $task->attributes;
		}
		return $task;
	}
	
	/**
	 * 让任务状态变成等待
	 * @author zhouwei<wei.w.zhou@integle.com>
	 * @copyright 2016-4-5 下午1:24:06
	 */
	public function actionTowait(){
		$taskId = $this->getParam('task_id', 0);
		$task = Task::findOne($taskId);
		if (empty($task)){
			return $this->ajaxFail('任务不存在');
		}
		$task->task_status = self::wait;
		if (!$task->save()){
			return $this->ajaxFail(array_values($task->getFirstErrors())[0]);
		}
	}
}