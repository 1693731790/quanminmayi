<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RobBuy;

/**
 * RobBuySearch represents the model behind the search form about `common\models\RobBuy`.
 */
class RobBuySearch extends RobBuy
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rob_id', 'shop_id', 'goods_id', 'num', 'start_time', 'end_time'], 'integer'],
            [['price'], 'number'],
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
        $query = RobBuy::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'rob_id' => SORT_DESC,            
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
            'rob_id' => $this->rob_id,
            'shop_id' => $this->shop_id,
            'goods_id' => $this->goods_id,
            'num' => $this->num,
            'price' => $this->price,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
        ]);

        return $dataProvider;
    }
}
