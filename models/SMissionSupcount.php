<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%s_mission_supcount}}".
 *
 * @property integer $id
 * @property integer $pro_type
 * @property integer $supplier_id
 * @property integer $pro_update_time
 * @property string $condition
 * @property integer $task_id
 */
class SMissionSupcount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%s_mission_supcount}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pro_type', 'supplier_id', 'pro_update_time', 'task_id'], 'required'],
            [['pro_type', 'supplier_id', 'pro_update_time', 'task_id'], 'integer'],
            [['condition'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'pro_type' => '产品类型：1,2,4,8',
            'supplier_id' => '供应商编号',
            'pro_update_time' => '供应商产品修改时间',
            'condition' => '额外条件json字符串',
            'task_id' => '任务编号',
        ];
    }
}
