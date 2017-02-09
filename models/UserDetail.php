<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user_detail}}".
 *
 * @property string $id
 * @property string $user_id
 * @property integer $gender
 * @property string $real_name
 * @property string $point
 * @property string $company_name
 * @property integer $job
 * @property string $office_phone
 * @property string $qq
 * @property integer $country_id
 * @property integer $province_id
 * @property integer $city_id
 * @property string $detail_address
 * @property string $post_code
 * @property string $id_card
 * @property integer $create_time
 * @property integer $update_time
 */
class UserDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_detail}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'create_time'], 'required'],
            [['user_id', 'gender', 'point', 'job', 'country_id', 'province_id', 'city_id', 'create_time', 'update_time'], 'integer'],
            [['real_name', 'office_phone', 'qq'], 'string', 'max' => 16],
            [['company_name'], 'string', 'max' => 64],
            [['detail_address'], 'string', 'max' => 128],
            [['post_code'], 'string', 'max' => 6],
            [['id_card'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户详情id',
            'user_id' => '用户id',
            'gender' => '性别(0保密，1男性，2女性)',
            'real_name' => '真实姓名',
            'point' => '积分',
            'company_name' => '公司名称',
            'job' => '职务
1、\'学生\', 2、 \'研究员\',3、 \'校长\',4、 \'教授\',5、 \'科学家\', 6、\'工程师\', 7、\'经理\', 8、\'总经理\',9、 \'其他\'',
            'office_phone' => '公司电话',
            'qq' => 'qq号码',
            'country_id' => '国家',
            'province_id' => '省(州)',
            'city_id' => '市(区)',
            'detail_address' => '详细地址',
            'post_code' => '邮编',
            'id_card' => '身份证号',
            'create_time' => '创建时间',
            'update_time' => 'Update Time',
        ];
    }
}
