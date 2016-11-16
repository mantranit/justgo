<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_product_file}}".
 *
 * @property integer $product_id
 * @property integer $file_id
 * @property integer $deleted
 */
class ProductFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_product_file}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'file_id'], 'required'],
            [['product_id', 'file_id', 'deleted'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'Product ID'),
            'file_id' => Yii::t('app', 'File ID'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }
}
