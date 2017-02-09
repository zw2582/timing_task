<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property string $id
 * @property string $email
 * @property integer $email_check_status
 * @property string $wechat_openid
 * @property string $phone
 * @property integer $phone_check_status
 * @property string $pass_word
 * @property string $old_pass_word
 * @property integer $error_count
 * @property integer $login_time
 * @property integer $reg_time
 * @property string $error_time
 * @property integer $status
 * @property string $session_id
 * @property string $ticket
 * @property string $token
 * @property integer $register_from
 * @property string $default_inventory
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'login_time', 'reg_time'], 'required'],
            [['email_check_status', 'phone_check_status', 'error_count', 'login_time', 'reg_time', 'error_time', 'status', 'register_from'], 'integer'],
            [['email', 'wechat_openid', 'pass_word', 'old_pass_word', 'session_id', 'default_inventory'], 'string', 'max' => 32],
            [['phone'], 'string', 'max' => 16],
            [['ticket', 'token'], 'string', 'max' => 64],
            [['email'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '用户uid',
            'email' => '邮箱',
            'email_check_status' => '邮箱是否验证',
            'wechat_openid' => '微信openid',
            'phone' => '手机号码',
            'phone_check_status' => '手机号是否验证',
            'pass_word' => '密码',
            'old_pass_word' => '老平台用户密码',
            'error_count' => '错误登录次数 5次错误后10分钟继续登录',
            'login_time' => 'Login Time',
            'reg_time' => 'Reg Time',
            'error_time' => '错误登录时间',
            'status' => '状态 1正常 0冻结',
            'session_id' => 'session_id',
            'ticket' => '单点登录ticket',
            'token' => '当前登录的token',
            'register_from' => '注册来源 1自己注册 其他对应数组',
            'default_inventory' => '用户默认库存ID',
        ];
    }
}
