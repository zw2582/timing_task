<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "integle_s_mission_error".
 *
 * @property string $id
 * @property string $missions_id
 * @property integer $line_number
 * @property string $error_info
 * @property string $content
 * @property string $create_time
 * @property integer $status
 */
class SMissionError extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'integle_s_mission_error';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['missions_id', 'line_number'], 'required'],
            [['missions_id', 'line_number', 'create_time', 'status'], 'integer'],
            [['error_info'], 'string'],
            [['content'], 'string', 'max' => 2000]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'missions_id' => 'Missions ID',
            'line_number' => 'Line Number',
            'error_info' => 'Error Info',
            'content' => 'Content',
            'create_time' => 'Create Time',
            'status' => 'Status',
        ];
    }
    
    /**
     * 添加日志
     * @author zhouwei<wei.w.zhou@integle.com>
     * @param unknown $missionId
     * @param unknown $line_number
     * @param unknown $error_info
     * @param string $content
     * @copyright 2016-4-11 下午3:44:47
     */
    public static function log($missionId, $line_number, $error_info, $content = ''){
        $error = new self();
        $error->attributes = [
            'missions_id' => $missionId,
            'line_number' => $line_number,
            'error_info' => $error_info,
            'content' => $content,
            'create_time' => time()
        ];
        $error->save ();
    }
    
}
