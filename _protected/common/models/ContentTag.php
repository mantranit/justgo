<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_content_tag}}".
 *
 * @property integer $content_id
 * @property integer $tag_id
 * @property integer $deleted
 */
class ContentTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_content_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content_id', 'tag_id'], 'required'],
            [['content_id', 'tag_id', 'deleted'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'content_id' => Yii::t('app', 'Content ID'),
            'tag_id' => Yii::t('app', 'Tag ID'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }
}
