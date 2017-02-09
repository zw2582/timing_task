<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%task}}".
 *
 * @property integer $id
 * @property integer $type_id
 * @property string $thread_no
 * @property integer $task_status
 * @property integer $version
 * @property integer $audit_version
 * @property integer $begin_time
 * @property integer $end_time
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%task}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id'], 'required'],
            [['type_id', 'task_status', 'version', 'audit_version', 'begin_time', 'end_time', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['thread_no'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => '任务类型：1.供应商产品上传，2.库存产品上传',
            'thread_no' => 'Thread No',
            'task_status' => '1.待处理，2.处理中，3.处理完成',
            'version' => '版本，用于判断进程执行次数',
            'audit_version' => '检测版本',
            'begin_time' => '开始时间',
            'end_time' => '结束时间',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '1.有效，0.无效',
        ];
    }
}
