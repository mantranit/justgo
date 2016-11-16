<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_arrangement}}".
 *
 * @property integer $id
 * @property integer $content_id
 * @property string $content_type
 * @property integer $sorting
 * @property integer $deleted
 */
class Arrangement extends \yii\db\ActiveRecord
{
    const TYPE_PRODUCT = 'product';
    const TYPE_NEWS = 'news';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_arrangement}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content_id', 'content_type'], 'required'],
            [['content_id', 'sorting', 'deleted'], 'integer'],
            [['content_type'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'content_id' => Yii::t('app', 'Content ID'),
            'content_type' => Yii::t('app', 'Content Type'),
            'sorting' => Yii::t('app', 'Sorting'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }
}
