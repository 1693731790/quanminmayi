<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GoodsComment;

/**
 * GoodsCommentSearch represents the model behind the search form about `common\models\GoodsComment`.
 */
class GoodsCommentSearch extends GoodsComment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'goods_id', 'order_id', 'user_id', 'type', 'goods_score', 'service_score', 'time_score', 'ishide', 'create_time'], 'integer'],
            [['content'], 'safe'],
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
        $query = GoodsComment::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'cid' => $this->cid,
            'goods_id' => $this->goods_id,
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'goods_score' => $this->goods_score,
            'service_score' => $this->service_score,
            'time_score' => $this->time_score,
            'ishide' => $this->ishide,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'images', $this->images]);

        return $dataProvider;
    }
}
