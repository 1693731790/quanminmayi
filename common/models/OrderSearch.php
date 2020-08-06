<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

/**
 * OrderSearch represents the model behind the search form about `common\models\Order`.
 */
class OrderSearch extends Order
{
  	public $error="";
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'order_sn', 'shop_id', 'status', 'pay_type', 'pay_time','is_comment','is_settlement','delivery_time', 'receive_time', 'create_time','refund_is_shop'], 'integer'],
            [['total_fee', 'deliver_fee'], 'number'],
            [['pay_num', 'remarks', 'refund_remarks',"is_seckill","order_yzh_sn","yzh_order_fail_code"], 'safe'],
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
        $query = Order::find();

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
		if($this->error=="1")
        {
          	 $query->andWhere(['status' => 1,'shop_id' => 1]);
             $query->andWhere(["is","order_yzh_sn",null]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'order_id' => $this->order_id,
            'user_id' => $this->user_id,
            'order_sn' => $this->order_sn,
            'shop_id' => $this->shop_id,
           
            'total_fee' => $this->total_fee,
            'deliver_fee' => $this->deliver_fee,
            
            'status' => $this->status,
            
            'pay_type' => $this->pay_type,
            'pay_time' => $this->pay_time,
            'is_comment' => $this->is_comment,
            'refund_is_shop' => $this->refund_is_shop,
            
            'is_settlement' => $this->is_settlement,
            'is_seckill' => $this->is_seckill,
            
            'delivery_time' => $this->delivery_time,
            'receive_time' => $this->receive_time,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'pay_num', $this->pay_num])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'refund_remarks', $this->refund_remarks]);

        return $dataProvider;
    }
}
