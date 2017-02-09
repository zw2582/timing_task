<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%s_promotion_tag}}".
 *
 * @property integer $id
 * @property integer $supplier_id
 * @property integer $pro_type
 * @property string $tag
 */
class SPromotionTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%s_promotion_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'pro_type', 'tag'], 'required'],
            [['supplier_id', 'pro_type'], 'integer'],
            [['tag'], 'string', 'max' => 64]
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
            'pro_type' => '产品类型，（1,2,4,8）',
            'tag' => '标记名称',
        ];
    }
}
