<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%s_mission_regular}}".
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property integer $pro_type
 * @property integer $task_id
 */
class SMissionRegular extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%s_mission_regular}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'pro_type', 'task_id'], 'required'],
            [['supplier_id', 'pro_type', 'task_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'supplier_id' => '供应商id',
            'pro_type' => '产品类型，1，化学品，2.生物试剂，4.仪器耗材，8.服务',
            'task_id' => '任务id',
        ];
    }
}
