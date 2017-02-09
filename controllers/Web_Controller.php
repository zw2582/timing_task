<?php
namespace app\controllers;

use yii\web\Controller;
use yii\helpers\StringHelper;
use yii\helpers\Json;
class Web_Controller extends Controller {
	
	public function ajaxSucc($msg, $data) {
		$this->ajaxReturn(1, $msg, $data);
	}
	
	public function ajaxFail($msg){
		$this->ajaxReturn(0, $msg, NULL);
	}
	
	public function ajaxReturn($status, $msg, $data){
		echo Json::encode([
			'status' => $status,
			'msg' => $msg,
			'data' => $data
		]);
	}
	
	public function getParam($name = NULL, $default = NULL){
		if (\Yii::$app->request->getMethod() == 'GET'){
			return \Yii::$app->request->get($name, $default);
		}else {
			return \Yii::$app->request->post($name, $default);
		}
	}
}