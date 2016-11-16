<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_product_category}}".
 *
 * @property integer $product_id
 * @property integer $category_id
 * @property integer $deleted
 */
class ProductCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_product_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'category_id'], 'required'],
            [['product_id', 'category_id', 'deleted'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'Product ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }
}
