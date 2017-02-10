定时任务系统（yii2基础项目）

目标:
1.实现大文件批量导入
2.实现长时间计算离线实现
3.对于正在执行的任务进行定时监控，对于非正常情况终止的进程能够自动重启

启动脚本:

1） ./yii hello/index不可以直接交给crontab允许，需要用该脚本commands/hello.sh包含，否则容易导致同时启动多个php进程导致服务器挂掉
	脚本目录在commonds目录下，脚本将php进程控制在3个以内，可以自己调整

2） 启动脚本将它配置给crontab,时间可以根据需要自定义,不可以使用inotifywait，因为系统需要定时监控执行中的任务

实现:

1.配置一种任务

	例如:config/params.php
	
	define('TASK_SUP_PRO_BIO', 3);  //生物试剂导入任务
	return [
	    'exec_path' => [
	        TASK_SUP_PRO_BIO => 'supplier_v1/biology/import',
	    ],
	];
	
2.web端上传一个csv文件，同时添加一个任务:

	例子:app\models\Task->actionAdd
	
	任务类型一定要指定，并且是已存在的


3.在supplier_v1/biology/import实现csv文件的解析代码

数据库:

(实例sql文件在/sql下)

表：task: 后台任务列表，一个系统只需要一个


具体业务需要表，一个系统中根据业务逻辑可以有多组mission和mission_error

表：mission:	表中必须要有task_id,其他的字段根据自己的业务逻辑改变,用于task任务执行时获取需要的业务参数

表：mission_error:	记录处理过程中出现的错误