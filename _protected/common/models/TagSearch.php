<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Tag;

/**
 * TagSearch represents the model behind the search form about `common\models\Tag`.
 */
class TagSearch extends Tag
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'deleted'], 'integer'],
            [['slug', 'name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Tag::find();
        if(isset($params['product_id'])) {
            $query->innerJoin('tbl_product_tag', 'tbl_tag.id = tbl_product_tag.tag_id');
            $query->where(['tbl_tag.deleted' => 0,
                            'tbl_product_tag.deleted' => 0,
                            'tbl_product_tag.product_id' => intval($params['product_id'])
                        ]);
        }
        elseif(isset($params['content_id'])) {
            $query->innerJoin('tbl_content_tag', 'tbl_tag.id = tbl_content_tag.tag_id');
            $query->where(['tbl_tag.deleted' => 0,
                'tbl_content_tag.deleted' => 0,
                'tbl_content_tag.content_id' => intval($params['content_id'])
            ]);
        }
        else {
            $query->where('deleted = 0');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
