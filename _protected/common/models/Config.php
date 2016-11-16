<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_config}}".
 *
 * @property string $key
 * @property string $value
 * @property string $group
 */
class Config extends \yii\db\ActiveRecord
{
    const GROUP_CONFIG = 'CONFIG';
    const GROUP_SEO = 'SEO';
    const GROUP_SOCIAL = 'SOCIAL';
    const GROUP_SUPPORT = 'SUPPORT';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'value', 'group'], 'required'],
            [['key', 'group'], 'string', 'max' => 32],
            [['value'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'key' => Yii::t('app', 'Key'),
            'value' => Yii::t('app', 'Value'),
            'group' => Yii::t('app', 'Group'),
        ];
    }
}
