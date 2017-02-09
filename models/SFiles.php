<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "integle_s_files".
 *
 * @property string $id
 * @property string $path
 * @property string $name
 * @property string $original_name
 * @property string $extension
 * @property string $url_origin
 * @property string $url_pathname
 * @property integer $status
 */
class SFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'integle_s_files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['path', 'name', 'original_name', 'url_origin', 'url_pathname'], 'string', 'max' => 255],
            [['extension'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'name' => 'Name',
            'original_name' => 'Original Name',
            'extension' => 'Extension',
            'url_origin' => 'Url Origin',
            'url_pathname' => 'Url Pathname',
            'status' => 'Status',
        ];
    }
}
