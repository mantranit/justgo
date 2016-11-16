<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_category}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $general
 * @property string $seo_title
 * @property string $seo_keyword
 * @property string $seo_description
 * @property integer $parent_id
 * @property integer $cat_type
 * @property integer $sorting
 * @property integer $show_in_menu
 * @property integer $activated
 * @property integer $deleted
 */
class Category extends \yii\db\ActiveRecord
{
    const CAT_TYPE_PRODUCT = 0;
    const CAT_TYPE_ARTICLE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['cat_type', 'sorting', 'show_in_menu', 'activated', 'deleted'], 'integer'],
            [['name', 'seo_title'], 'string', 'max' => 256],
            [['seo_description', 'seo_keyword'], 'string', 'max' => 512],
            [['slug'], 'string', 'max' => 128],
            [['description', 'general'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => 'Tên danh mục',
            'slug' => Yii::t('app', 'Slug'),
            'description' => 'Mô tả',
            'general' => 'Thông tin chung SP',
            'seo_title' => Yii::t('app', 'SEO Title'),
            'seo_keyword' => Yii::t('app', 'SEO Keyword'),
            'seo_description' => Yii::t('app', 'SEO Description'),
            'cat_type' => Yii::t('app', 'Type'),
            'parent_id' => 'Danh mục cha',
            'sorting' => 'Sắp xếp',
            'show_in_menu' => 'Hiển thị',
            'activated' => 'Kích hoạt',
            'deleted' => Yii::t('app', 'Deleted'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * @param int $id
     * @param int $type
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getParents($id = 0, $type = 0, $active = 1)
    {
        if($id && $id > 0) {
            if($active === 1) {
                return Category::find()->where("cat_type = '$type' AND activated = 1 AND deleted = 0 AND parent_id = 0 AND id != '$id'")->orderBy('sorting')->all();
            }
            else {
                return Category::find()->where("cat_type = '$type' AND deleted = 0 AND parent_id = 0 AND id != '$id'")->orderBy('sorting')->all();
            }
        }
        else {
            if($active === 1) {
                return Category::find()->where(['cat_type' => $type, 'activated' => 1, 'deleted' => 0, 'parent_id' => 0])->orderBy('sorting')->all();
            }
            else {
                return Category::find()->where(['cat_type' => $type, 'deleted' => 0, 'parent_id' => 0])->orderBy('sorting')->all();
            }
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
                $exist = Category::findOne(['slug' => $result]);
            }
            else {
                $exist = Category::findOne(['AND', ['=', 'slug', $result], ['<>', 'id', $id]]);
            }
            if($exist === null) {
                break;
            }
            $i++;
        }
        return $result;
    }

    /**
     * @param int $type
     * @return array
     */
    public static function getTree($type = 0)
    {
        $result = [];
        $parent = self::getParents(0, $type);
        foreach($parent as $papa) {
            $tmp['id'] = $papa->id;
            $tmp['name'] = $papa->name;
            $tmp['slug'] = $papa->slug;
            $tmp['show_in_menu'] = $papa->show_in_menu;
            $tmp['activated'] = $papa->activated;
            $tmp['children'] = [];
            foreach(Category::find()->where(['activated' => 1, 'deleted' => 0, 'parent_id' => $papa->id])->orderBy('sorting')->all() as $child) {
                $tmpChild['id'] = $child->id;
                $tmpChild['name'] = $child->name;
                $tmpChild['slug'] = $child->slug;
                $tmpChild['show_in_menu'] = $child->show_in_menu;
                $tmpChild['activated'] = $child->activated;
                $tmp['children'][] = $tmpChild;
            }
            $result[] = $tmp;
        }
        return $result;
    }

    /**
     * @param int $type
     * @return array
     */
    public static function getTreeView($type = 0)
    {
        $result = [];
        $parent = self::getParents(0, $type);
        foreach($parent as $papa) {
            $result[$papa->id] = $papa->name;
            foreach(Category::find()->where(['activated' => 1, 'deleted' => 0, 'parent_id' => $papa->id])->orderBy('sorting')->all() as $child) {
                $result[$child->id] = '|__' . $child->name;
            }
        }
        return $result;
    }
}
