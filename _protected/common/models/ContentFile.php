<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_content_file}}".
 *
 * @property integer $content_id
 * @property integer $file_id
 * @property integer $deleted
 */
class ContentFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_content_file}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content_id', 'file_id'], 'required'],
            [['content_id', 'file_id', 'deleted'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'content_id' => Yii::t('app', 'Content ID'),
            'file_id' => Yii::t('app', 'File ID'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }
}
