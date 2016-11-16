<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\File;

/**
 * FileSearch represents the model behind the search form about `common\models\File`.
 */
class FileSearch extends File
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'width', 'height', 'deleted'], 'integer'],
            [['name', 'caption', 'show_url', 'directory', 'media', 'dimension', 'file_name', 'file_type', 'file_size', 'file_ext'], 'safe'],
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
        $query = File::find();
        if(isset($params['product_id'])) {
            $query->innerJoin('tbl_product_file', 'tbl_file.id = tbl_product_file.file_id');
            $query->where(['tbl_file.deleted' => 0,
                            'tbl_product_file.deleted' => 0,
                            'tbl_product_file.product_id' => intval($params['product_id'])
                        ]);
        }
        elseif(isset($params['content_id'])) {
            $query->innerJoin('tbl_content_file', 'tbl_file.id = tbl_content_file.file_id');
            $query->where(['tbl_file.deleted' => 0,
                'tbl_content_file.deleted' => 0,
                'tbl_content_file.content_id' => intval($params['content_id'])
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
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'width' => $this->width,
            'height' => $this->height,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'caption', $this->caption])
            ->andFilterWhere(['like', 'show_url', $this->show_url])
            ->andFilterWhere(['like', 'media', $this->media])
            ->andFilterWhere(['like', 'directory', $this->directory])
            ->andFilterWhere(['like', 'dimension', $this->dimension])
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'file_type', $this->file_type])
            ->andFilterWhere(['like', 'file_size', $this->file_size])
            ->andFilterWhere(['like', 'file_ext', $this->file_ext]);

        return $dataProvider;
    }
}
