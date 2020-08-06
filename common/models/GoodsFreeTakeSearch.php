<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GoodsFreeTake;

/**
 * GoodsFreeTakeSearch represents the model behind the search form about `common\models\GoodsFreeTake`.
 */
class GoodsFreeTakeSearch extends GoodsFreeTake
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'user_num', 'stock', 'salecount', 'browse', 'issale', 'create_time'], 'integer'],
            [['goods_sn', 'goods_name', 'goods_keys', 'desc', 'status', 'status_info', 'content', 'mobile_content'], 'safe'],
            [['old_price'], 'number'],
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
        $query = GoodsFreeTake::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
          	 'sort' => [
                'defaultOrder' => [
                    'goods_id' => SORT_DESC,            
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
            'goods_id' => $this->goods_id,
            'user_num' => $this->user_num,
            'old_price' => $this->old_price,
            'stock' => $this->stock,
            'salecount' => $this->salecount,
            'browse' => $this->browse,
            'issale' => $this->issale,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'goods_sn', $this->goods_sn])
            ->andFilterWhere(['like', 'goods_name', $this->goods_name])
            ->andFilterWhere(['like', 'goods_keys', $this->goods_keys])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'status_info', $this->status_info])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'mobile_content', $this->mobile_content]);

        return $dataProvider;
    }
}
