<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%s_pro_biology}}".
 *
 * @property string $id
 * @property string $supplier_id
 * @property string $number
 * @property string $cas
 * @property string $ics
 * @property string $brand
 * @property string $cn_name
 * @property string $en_name
 * @property string $deep_path
 * @property string $save_name
 * @property string $tstg
 * @property string $description
 * @property string $website
 * @property integer $mission_id
 * @property string $user_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $status
 */
class SProBiology extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%s_pro_biology}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number', 'supplier_id', 'user_id'], 'required'],
            [['supplier_id', 'mission_id', 'user_id', 'create_time', 'update_time', 'status'], 'integer'],
            [['number', 'cas', 'ics'], 'string', 'max' => 64],
            [['brand'], 'string', 'max' => 32],
            [['cn_name', 'en_name', 'website','deep_path','save_name','tstg'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 500],
            [['mission_id'], 'default', 'value'=>0]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '商品ID',
            'supplier_id' => '供应商ID',
            'number' => '供应商自己对产品的编码',
            'cas' => 'cas号',
            'ics' => 'ICS',
            'brand' => '品牌',
            'cn_name' => '中文商品名称',
            'en_name' => '英文商品名称',
            'deep_path' => '主图保存相对路径',
            'save_name' => '主图文件保存名称',
            'tstg' => '存储温度',
            'description' => '描述',
            'website' => '商品网址',
            'mission_id' => '上传队列编号',
            'user_id' => '上传人ID',
            'create_time' => '创建时间',
            'update_time' => '修改时间',
            'status' => '有效值，1.有效，0.无效',
        ];
    }
    
    public function beforeSave($insert) {
        $this->update_time = time();
        if ($insert) {
            $this->create_time = time();
        }
        return parent::beforeSave($insert);
    }
    
    public function getStock() {
        return $this->hasOne(stockSupplier::className(), ['product_id'=>'id'])->onCondition(['pro_type'=>Product::BIOLOGY_INDEX]);
    }
}
