<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Article;

/**
 * ArticleSearch represents the model behind the search form about `common\models\Article`.
 */
class AcArticleSearch extends AcArticle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'ishot', 'create_time',"status","cate_id"], 'integer'],
            [['title',  'key', 'desc', 'content', 'author'], 'safe'],
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
        $query = AcArticle::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
          	'sort' => [
                'defaultOrder' => [
                    'article_id' => SORT_DESC,            
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'article_id' => $this->article_id,
            'ishot' => $this->ishot,
            'create_time' => $this->create_time,
          'cate_id' => $this->cate_id,
          'agent_id' => $this->agent_id,
          'type' => $this->type,
          'status' => $this->status,
          
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'title_img', $this->title_img])
            ->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'author', $this->author]);

        return $dataProvider;
    }
}
