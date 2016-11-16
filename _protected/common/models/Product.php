<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_product}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $image_id
 * @property string $description
 * @property string $general
 * @property string $info_tech
 * @property string $price_init
 * @property string $price
 * @property string $discount
 * @property string $price_string
 * @property integer $is_hot
 * @property integer $is_discount
 * @property integer $viewed
 * @property string $status
 * @property string $seo_title
 * @property string $seo_keyword
 * @property string $seo_description
 * @property integer $published_date
 * @property integer $updated_date
 * @property integer $created_date
 * @property string $created_by
 * @property integer $activated
 * @property integer $deleted
 */
class Product extends \yii\db\ActiveRecord
{
    const STATUS_DRAFT = 'draft';
    const STATUS_WAITING = 'waiting';
    const STATUS_LIEN_HE = 'lienhe';
    const STATUS_INSTOCK = 'instock';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_date', 'created_by'], 'required'],
            [['image_id', 'is_hot', 'is_discount', 'viewed', 'published_date', 'updated_date', 'created_date', 'activated', 'deleted'], 'integer'],
            [['general', 'info_tech', 'status'], 'string'],
            [['price_init', 'price'], 'number'],
            [['name', 'seo_title'], 'string', 'max' => 256],
            [['seo_description', 'seo_keyword'], 'string', 'max' => 512],
            [['slug'], 'string', 'max' => 128],
            [['description', 'price_string', 'info_tech', 'general'], 'safe'],
            [['created_by'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => 'Tên sản phẩm',
            'slug' => Yii::t('app', 'Slug'),
            'image_id' => Yii::t('app', 'Image'),
            'description' => 'Mô tả ngắn',
            'general' => 'Tổng quan',
            'info_tech' => 'Thông số kỷ thuật',
            'price_init' => Yii::t('app', 'Price Init'),
            'price' => 'Giá',
            'discount' => 'Giảm',
            'price_string' => 'Quản lý giá',
            'is_hot' => 'Sản phẩm hot',
            'is_discount' => 'Sản phẩm giảm giá',
            'viewed' => Yii::t('app', 'Viewed'),
            'status' => 'Trạng thái',
            'seo_title' => Yii::t('app', 'Seo Title'),
            'seo_keyword' => Yii::t('app', 'Seo Keyword'),
            'seo_description' => Yii::t('app', 'Seo Description'),
            'published_date' => Yii::t('app', 'Published Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
            'created_date' => Yii::t('app', 'Created Date'),
            'created_by' => Yii::t('app', 'Created By'),
            'activated' => Yii::t('app', 'Activated'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->hasOne(File::className(), ['id' => 'image_id']);
    }

    /**
     * Returns the array of possible product status values.
     *
     * @return array
     */
    public function getStatusList()
    {
        $statusArray = [
            self::STATUS_INSTOCK    => 'Còn hàng',
            self::STATUS_WAITING   => 'Cháy hàng',
            self::STATUS_LIEN_HE   => 'Liên hệ',
            self::STATUS_DRAFT => 'Tạm'
        ];

        return $statusArray;
    }

    /**
     * Returns the array of possible product status values.
     *
     * @return array
     */
    public function getStatusListEdit()
    {
        $statusArray = [
            self::STATUS_INSTOCK    => 'Còn hàng',
            self::STATUS_WAITING   => 'Cháy hàng',
            self::STATUS_LIEN_HE   => 'Liên hệ',
        ];

        return $statusArray;
    }

    public static function isShowing(){
        return [self::STATUS_INSTOCK, self::STATUS_WAITING, self::STATUS_LIEN_HE];
    }

    /**
     * Returns the gallery status in nice format.
     *
     * @param null|integer $status Status integer value if sent to method.
     * @return string              Nicely formatted status.
     */
    public function getStatusName($status = null)
    {
        $status = (empty($status)) ? $this->status : $status ;

        if ($status === self::STATUS_INSTOCK)
        {
            return "Còn hàng";
        }
        elseif ($status === self::STATUS_WAITING)
        {
            return "Cháy hàng";
        }
        elseif ($status === self::STATUS_LIEN_HE)
        {
            return "Liên hệ";
        }
        else
        {
            return "Tạm";
        }
    }

    /**
     * @param string $slug
     * @param int $id
     * @return string
     */
    public function getSlug($slug, $id = 0)
    {
        $result = $slug;
        $i = 0;
        while (true) {
            if($i > 0)
                $result = $slug . $i;
            if ($id === 0) {
                $exist = self::findOne(['slug' => $result]);
            }
            else {
                $exist = self::findOne(['AND', ['=', 'slug', $result], ['<>', 'id', $id]]);
            }
            if($exist === null) {
                break;
            }
            $i++;
        }
        return $result;
    }

    /**
     * @return  \common\models\Category|null
     */
    public function getCategory() {
        $query = Category::find()
            ->innerJoin('tbl_product_category pc', 'tbl_category.id = pc.category_id')
            ->where(['tbl_category.activated' => 1, 'tbl_category.deleted' => 0, 'pc.product_id' => $this->id]);
        $categories = $query->all();
        if($categories !== null) {
            return $categories[0];
        }
        else {
            return null;
        }
    }

    /**
     * @param $categoryId
     * @return static
     */
    public static function getProductByParentCategory($categoryId) {
        $categoryObjects = Category::findAll(['activated' => 1, 'deleted' => 0, 'parent_id' => $categoryId]);
        $categoryArray = [$categoryId];
        foreach ($categoryObjects as $index => $category) {
            array_push($categoryArray, $category->id);
        }
        $query = self::find()
            ->distinct()
            ->innerJoin('tbl_product_category', 'tbl_product_category.product_id = tbl_product.id')
            ->where([
                'tbl_product_category.deleted' => 0,
                'tbl_product.activated' => 1,
                'tbl_product.deleted' => 0,
                'tbl_product.status' => self::isShowing(),
            ])
            ->andWhere(['IN', 'tbl_product_category.category_id', $categoryArray]);
        return $query;
    }

    /**
     * @param $categoryId
     * @return static
     */
    public static function getProductByChildCategory($categoryId) {
        $query = self::find()
            ->innerJoin('tbl_product_category', 'tbl_product_category.product_id = tbl_product.id')
            ->where([
                'tbl_product_category.deleted' => 0,
                'tbl_product.activated' => 1,
                'tbl_product.deleted' => 0,
                'tbl_product.status' => self::isShowing(),
                'tbl_product_category.category_id' => $categoryId,
            ]);
        return $query;
    }
}
