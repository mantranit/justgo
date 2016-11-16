<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_product_tag}}".
 *
 * @property integer $product_id
 * @property integer $tag_id
 * @property integer $deleted
 */
class ProductTag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_product_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'tag_id'], 'required'],
            [['product_id', 'tag_id', 'deleted'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'Product ID'),
            'tag_id' => Yii::t('app', 'Tag ID'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }
}
