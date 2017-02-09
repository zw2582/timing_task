<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%s_pro_bdetail}}".
 *
 * @property string $id
 * @property string $bio_id
 * @property string $purity
 * @property string $package_count
 * @property string $package_unit_id
 * @property string $package
 * property integer $promotion_tag_id
 * @property string $price
 * @property integer $inventory_status
 * @property string $stock_time
 * @property string $delivery_time
 * @property integer $promotion
 * @property string $off_shelf_time
 * @property integer $shelf_status
 * @property string $discount_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 */
class SProBdetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%s_pro_bdetail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bio_id'], 'required'],
            [['bio_id', 'package_unit_id', 'inventory_status', 'stock_time', 'delivery_time', 'promotion', 'off_shelf_time', 'shelf_status', 'discount_id', 'create_time', 'update_time', 'status','promotion_tag_id'], 'integer'],
            [['price', 'package_count'], 'number'],
            [['purity','package'], 'string', 'max' => 255],
            [['inventory_status'], 'default', 'value'=>1],
            [['package_count', 'package_unit_id', 'price', 'stock_time', 'delivery_time', 'off_shelf_time', 'shelf_status', 'discount_id', 'promotion'], 'default', 'value'=>0]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '商品ID',
            'bio_id' => '生物制剂id',
            'purity' => '纯度',
            'package_count' => '规格数量',
            'package_unit_id' => '规格单位',
            'package'=>'包装规格',
            'promotion_tag_id'=>'促销标记id',
            'price' => '单价(元)',
            'inventory_status' => '库存状态 1、现货 2、期货',
            'stock_time' => '备货期(天)',
            'delivery_time' => '发货时间',
            'promotion' => '促销 0、未促销 1、促销',
            'off_shelf_time' => '下架时间（时间戳）',
            'shelf_status' => '上下架状态 1、上架 0、下架',
            'discount_id' => '折扣ID',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '有效值，1.有效，0.无效',
        ];
    }
    
    public function beforeSave($insert) {
        if ($insert) {
            $this->create_time = time();
            $this->update_time = time();
        }else {
            $this->update_time = time();
        }
        return parent::beforeSave($insert);
    }
}
