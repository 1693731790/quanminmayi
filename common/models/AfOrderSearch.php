<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AfOrder;

/**
 * AfOrderSearch represents the model behind the search form about `common\models\AfOrder`.
 */
class AfOrderSearch extends AfOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'd_id', 'user_id', 'status', 'create_time',"goods_id","num"], 'integer'],
            [['order_sn', 'address_name', 'address_phone', 'address_region', 'address_region_id', 'address_address', 'pay_img', 'remarks', 'express_type', 'express_num',"goods_name"], 'safe'],
            [['total_fee'], 'number'],
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
        $query = AfOrder::find();

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
            'd_id' => $this->d_id,
            'user_id' => $this->user_id,
            'total_fee' => $this->total_fee,
            'status' => $this->status,
            'goods_id' => $this->goods_id,
            'num' => $this->num,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'order_sn', $this->order_sn])
            ->andFilterWhere(['like', 'address_name', $this->address_name])
            ->andFilterWhere(['like', 'address_phone', $this->address_phone])
            ->andFilterWhere(['like', 'address_region', $this->address_region])
            ->andFilterWhere(['like', 'address_region_id', $this->address_region_id])
            ->andFilterWhere(['like', 'address_address', $this->address_address])
            ->andFilterWhere(['like', 'pay_img', $this->pay_img])
            ->andFilterWhere(['like', 'goods_name', $this->goods_name])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'express_type', $this->express_type])
            ->andFilterWhere(['like', 'express_num', $this->express_num]);

        return $dataProvider;
    }
}
