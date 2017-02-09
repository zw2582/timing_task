<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "integle_s_package_unit".
 *
 * @property string $id
 * @property integer $product_type
 * @property string $en_name
 * @property string $cn_name
 * @property integer $status
 */
class SPackageUnit extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'integle_s_package_unit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_type', 'status'], 'integer'],
            [['en_name', 'cn_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_type' => 'Product Type',
            'en_name' => 'En Name',
            'cn_name' => 'Cn Name',
            'status' => 'Status',
        ];
    }
}
