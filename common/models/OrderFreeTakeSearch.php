<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrderFreeTake;

/**
 * OrderFreeTakeSearch represents the model behind the search form about `common\models\OrderFreeTake`.
 */
class OrderFreeTakeSearch extends OrderFreeTake
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'user_num', 'get_user_num', 'goods_id', 'status', 'is_comment'], 'integer'],
            [['order_sn', 'goods_name', 'address_name', 'address_phone', 'address_region', 'address_region_id', 'address_address', 'remarks', 'express_type', 'express_num'], 'safe'],
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
        $query = OrderFreeTake::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
          	'sort' => [
                'defaultOrder' => [
                    'order_id' => SORT_DESC,            
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
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'user_num' => $this->user_num,
            'get_user_num' => $this->get_user_num,
            'goods_id' => $this->goods_id,
            'status' => $this->status,
            'is_comment' => $this->is_comment,
           
        ]);

        $query->andFilterWhere(['like', 'order_sn', $this->order_sn])
            ->andFilterWhere(['like', 'goods_name', $this->goods_name])
            ->andFilterWhere(['like', 'address_name', $this->address_name])
            ->andFilterWhere(['like', 'address_phone', $this->address_phone])
            ->andFilterWhere(['like', 'address_region', $this->address_region])
            ->andFilterWhere(['like', 'address_region_id', $this->address_region_id])
            ->andFilterWhere(['like', 'address_address', $this->address_address])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'express_type', $this->express_type])
            ->andFilterWhere(['like', 'express_num', $this->express_num]);

        return $dataProvider;
    }
}
