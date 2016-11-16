<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_product_related}}".
 *
 * @property integer $product_id
 * @property integer $related_id
 * @property integer $sorting
 * @property integer $deleted
 */
class ProductRelated extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_product_related}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'related_id'], 'required'],
            [['product_id', 'related_id', 'sorting', 'deleted'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'Product ID'),
            'related_id' => Yii::t('app', 'Related ID'),
            'sorting' => Yii::t('app', 'Sorting'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }
}
