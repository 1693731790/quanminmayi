<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShopCoupon;

/**
 * ShopCouponSearch represents the model behind the search form about `common\models\ShopCoupon`.
 */
class ShopCouponSearch extends ShopCoupon
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_coupon_id', 'shop_id', 'end_time'], 'integer'],
            [['fee'], 'number'],
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
        $query = ShopCoupon::find();

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
            'shop_coupon_id' => $this->shop_coupon_id,
            'shop_id' => $this->shop_id,
            'fee' => $this->fee,
            'end_time' => $this->end_time,
        ]);

        return $dataProvider;
    }
}
