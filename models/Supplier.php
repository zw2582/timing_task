<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "integle_supplier".
 *
 * @property integer $id
 * @property string $logo_url
 * @property string $deep_path
 * @property string $save_name
 * @property string $simple_name
 * @property string $company_name
 * @property string $business_type
 * @property string $country_id
 * @property string $province_id
 * @property string $city_id
 * @property string $detail_address
 * @property string $post
 * @property string $tel
 * @property string $fax
 * @property string $website
 * @property string $tag
 * @property integer $interface_status
 * @property string $ak
 * @property integer $ak_status
 * @property string $contact_name
 * @property string $contact_phone
 * @property string $contact_qq
 * @property string $contact_email
 * @property string $user_id
 * @property string $create_time
 * @property string $update_time
 * @property integer $certificate_status
 * @property integer $status
 * @property integer $grade
 * @property integer $product_is_show
 * @property integer $product_is_shopping
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'integle_supplier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'province_id', 'city_id', 'interface_status', 'ak_status', 'user_id', 'create_time', 'update_time', 'certificate_status', 'status', 'grade', 'product_is_show', 'product_is_shopping'], 'integer'],
            [['user_id', 'create_time', 'update_time'], 'required'],
            [['logo_url'], 'string', 'max' => 512],
            [['deep_path'], 'string', 'max' => 10],
            [['save_name'], 'string', 'max' => 32],
            [['simple_name', 'company_name', 'detail_address', 'website', 'tag', 'contact_name'], 'string', 'max' => 255],
            [['business_type', 'fax', 'ak'], 'string', 'max' => 64],
            [['post', 'tel', 'contact_phone', 'contact_qq'], 'string', 'max' => 16],
            [['contact_email'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'logo_url' => 'Logo Url',
            'deep_path' => 'Deep Path',
            'save_name' => 'Save Name',
            'simple_name' => 'Simple Name',
            'company_name' => 'Company Name',
            'business_type' => 'Business Type',
            'country_id' => 'Country ID',
            'province_id' => 'Province ID',
            'city_id' => 'City ID',
            'detail_address' => 'Detail Address',
            'post' => 'Post',
            'tel' => 'Tel',
            'fax' => 'Fax',
            'website' => 'Website',
            'tag' => 'Tag',
            'interface_status' => 'Interface Status',
            'ak' => 'Ak',
            'ak_status' => 'Ak Status',
            'contact_name' => 'Contact Name',
            'contact_phone' => 'Contact Phone',
            'contact_qq' => 'Contact Qq',
            'contact_email' => 'Contact Email',
            'user_id' => 'User ID',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'certificate_status' => 'Certificate Status',
            'status' => 'Status',
            'grade' => 'Grade',
            'product_is_show' => 'Product Is Show',
            'product_is_shopping' => 'Product Is Shopping',
        ];
    }
}
