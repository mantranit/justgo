<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_file}}".
 *
 * @property string $id
 * @property string $name
 * @property string $caption
 * @property string $show_url
 * @property string $media
 * @property string $directory
 * @property string $dimension
 * @property integer $width
 * @property integer $height
 * @property string $file_name
 * @property string $file_type
 * @property string $file_size
 * @property string $file_ext
 * @property integer $deleted
 */
class File extends \yii\db\ActiveRecord
{
    const MEDIA_IMAGE = 'image';
    const MEDIA_DOCUMENT = 'document';
    const MEDIA_AUDIO = 'audio';
    const MEDIA_VIDEO = 'video';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_file}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'show_url', 'directory', 'file_name', 'file_type', 'file_size', 'file_ext'], 'required'],
            [['width', 'height', 'deleted'], 'integer'],
            [['media'], 'string'],
            [['name', 'show_url', 'directory'], 'string', 'max' => 128],
            [['caption'], 'string', 'max' => 1024],
            [['dimension', 'file_type', 'file_size'], 'string', 'max' => 16],
            [['file_name'], 'string', 'max' => 128],
            [['file_ext'], 'string', 'max' => 8]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'caption' => Yii::t('app', 'Caption'),
            'show_url' => Yii::t('app', 'Show Url'),
            'directory' => Yii::t('app', 'Directory'),
            'media' => Yii::t('app', 'Media'),
            'dimension' => Yii::t('app', 'Dimension'),
            'width' => Yii::t('app', 'Width'),
            'height' => Yii::t('app', 'Height'),
            'file_name' => Yii::t('app', 'File Name'),
            'file_type' => Yii::t('app', 'File Type'),
            'file_size' => Yii::t('app', 'File Size'),
            'file_ext' => Yii::t('app', 'File Ext'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }
}
