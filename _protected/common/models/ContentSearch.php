<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Content;

/**
 * ContentSearch represents the model behind the search form about `common\models\Content`.
 */
class ContentSearch extends Content
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'image_id', 'published_date', 'using_page_builder', 'parent_id', 'show_in_menu', 'updated_date', 'sorting', 'created_date', 'deleted'], 'integer'],
            [['name', 'slug', 'content_type', 'summary', 'seo_title', 'seo_keyword', 'seo_description', 'status', 'created_by'], 'safe'],
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
     * @param bool $sorting
     *
     * @return ActiveDataProvider
     */
    public function search($params, $sorting = false)
    {
        $query = Content::find();
        $query->where('deleted = 0');
        if($sorting) {
            $query->orderBy('sorting');
        }
        else {
            $query->orderBy('created_date DESC');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'image_id' => $this->image_id,
            'published_date' => $this->published_date,
            'using_page_builder' => $this->using_page_builder,
            'parent_id' => $this->parent_id,
            'show_in_menu' => $this->show_in_menu,
            'updated_date' => $this->updated_date,
            'sorting' => $this->sorting,
            'created_date' => $this->created_date,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'content_type', $this->content_type])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'seo_title', $this->seo_title])
            ->andFilterWhere(['like', 'seo_keyword', $this->seo_keyword])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'created_by', $this->created_by]);

        return $dataProvider;
    }
}
