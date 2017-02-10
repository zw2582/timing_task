定时任务系统

目标：
1.实现大文件批量导入
2.实现长时间计算离线实现

启动脚本：
yii hello/index;

实现：
1.配置一种任务
	例如：config/params.php
	
	define('TASK_SUP_PRO_BIO', 3);  //生物试剂导入任务
	return [
	    'exec_path' => [
	        TASK_SUP_PRO_BIO => 'supplier_v1/biology/import',
	    ],
	];
	
2.web端上传一个csv文件，同时添加一个任务：
	例子：app\models\Task->actionAdd
	任务类型一定要指定，并且是已存在的

3.在supplier_v1/biology/import实现csv文件的解析代码

数据库：
(实例sql文件在/sql下)
task： 后台任务列表，一个系统只需要一个

具体业务需要表，一个系统中根据业务逻辑可以有多组mission和mission_error
mission:	表中必须要有task_id,其他的字段根据自己的业务逻辑改变,用于task任务执行时获取需要的业务参数
mission_error：	记录处理过程中出现的错误