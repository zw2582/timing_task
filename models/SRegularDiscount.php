<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%s_regular_discount}}".
 *
 * @property string $id
 * @property integer $supplier_id
 * @property string $number
 * @property string $regular
 * @property integer $target
 * @property integer $type
 * @property integer $rate
 * @property string $price
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $user_id
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $status
 */
class SRegularDiscount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%s_regular_discount}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'number', 'regular', 'start_time', 'user_id', 'create_time'], 'required'],
            [['supplier_id', 'target', 'type', 'rate', 'start_time', 'end_time', 'user_id', 'create_time', 'update_time', 'status'], 'integer'],
            [['price'], 'number'],
            [['number'], 'string', 'max' => 32],
            [['regular'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'supplier_id' => '供应商编号',
            'number' => '编号',
            'regular' => '规则，json形式',
            'target' => '分享对象，1.所有用户，2.鹰群',
            'type' => '折扣方式：1.折扣率，2.折后价',
            'rate' => '折扣率',
            'price' => '折后价',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'user_id' => '用户编号',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '是否有效，1.有效，0.无效',
        ];
    }
}
