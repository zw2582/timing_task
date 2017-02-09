<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "integle_s_mission".
 *
 * @property string $id
 * @property string $number
 * @property string $deep_path 
 * @property string $save_name 
 * @property string $real_name 
 * @property integer $sfile_id
 * @property integer $handle_status
 * @property integer $line
 * @property integer $audit_line
 * @property integer $total_line
 * @property integer $success_line
 * @property string $thread_no
 * @property integer $task_id
 * @property integer $pro_type
 * @property integer $supplier_id
 * @property string $user_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 */
class SMission extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'integle_s_mission';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'deep_path', 'save_name', 'real_name', 'sfile_id', 'task_id', 'pro_type', 'supplier_id', 'user_id'], 'required'],
            [['sfile_id', 'handle_status', 'line', 'audit_line', 'total_line', 'success_line', 'task_id', 'pro_type', 'supplier_id', 'user_id', 'create_time', 'update_time', 'status'], 'integer'],
            [['number'], 'string', 'max' => 32],
            [['thread_no'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
           'id' => '任务处理记录表id',
           'number' => '上传编号',
           'deep_path' => 'csv文件相对路径',
           'save_name' => 'csv文件名称',
           'real_name' => '真实名称',
           'sfile_id' => '文件名编号【废弃】',
           'handle_status' => '处理结果表 0未处理 1处理中 2处理完毕',
           'line' => '执行到的行数',
           'audit_line' => '检查行数',
           'total_line' => '总行数',
           'success_line' => '成功行数',
           'thread_no' => '进程号',
           'task_id' => '任务编号',
           'pro_type' => '产品类型 1、化学品 2、生物制剂 4、仪器耗材 8、服务 ',
           'supplier_id' => '库存编号',
           'user_id' => '用户编号',
           'create_time' => '创建时间',
           'update_time' => '修改时间',
           'status' => '该记录的状态 1正常 0逻辑删除',
        ];
    }
    
    public function getUserDetail() {
        return $this->hasOne(UserDetail::className(), ['user_id'=>'user_id']);
    }
}
