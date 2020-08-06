<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\OrderSeckill;

/**
 * OrderSeckillSearch represents the model behind the search form about `common\models\OrderSeckill`.
 */
class OrderSeckillSearch extends OrderSeckill
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'goods_id', 'num', 'status', 'pay_status', 'pay_type', 'pay_time', 'refund_time', 'create_time'], 'integer'],
            [['order_sn', 'goods_name', 'goods_thums', 'address_name', 'address_phone', 'address_region', 'address_region_id', 'address_address', 'pay_num', 'remarks', 'refund_remarks', 'express_type', 'express_num'], 'safe'],
            [['price', 'total_fee'], 'number'],
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
        $query = OrderSeckill::find();

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
            'goods_id' => $this->goods_id,
            'price' => $this->price,
            'num' => $this->num,
            'total_fee' => $this->total_fee,
            'status' => $this->status,
            'pay_status' => $this->pay_status,
            'pay_type' => $this->pay_type,
            'pay_time' => $this->pay_time,
            'refund_time' => $this->refund_time,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'order_sn', $this->order_sn])
            ->andFilterWhere(['like', 'goods_name', $this->goods_name])
            ->andFilterWhere(['like', 'goods_thums', $this->goods_thums])
            ->andFilterWhere(['like', 'address_name', $this->address_name])
            ->andFilterWhere(['like', 'address_phone', $this->address_phone])
            ->andFilterWhere(['like', 'address_region', $this->address_region])
            ->andFilterWhere(['like', 'address_region_id', $this->address_region_id])
            ->andFilterWhere(['like', 'address_address', $this->address_address])
            ->andFilterWhere(['like', 'pay_num', $this->pay_num])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'refund_remarks', $this->refund_remarks])
            ->andFilterWhere(['like', 'express_type', $this->express_type])
            ->andFilterWhere(['like', 'express_num', $this->express_num]);

        return $dataProvider;
    }
}
