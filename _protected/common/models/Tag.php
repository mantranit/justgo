<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%tbl_tag}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property integer $deleted
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tbl_tag}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['deleted'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 128],
            [['slug'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => 'Tag',
            'slug' => Yii::t('app', 'Slug'),
            'deleted' => Yii::t('app', 'Deleted'),
        ];
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
                $exist = Tag::findOne(['slug' => $result]);
            }
            else {
                $exist = Tag::findOne(['AND', ['=', 'slug', $result], ['<>', 'id', $id]]);
            }
            if($exist === null) {
                break;
            }
            $i++;
        }
        return $result;
    }
}
