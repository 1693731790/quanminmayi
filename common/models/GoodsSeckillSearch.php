<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GoodsSeckill;

/**
 * GoodsSeckillSearch represents the model behind the search form about `common\models\GoodsSeckill`.
 */
class GoodsSeckillSearch extends GoodsSeckill
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'stock'], 'integer'],
            [['goods_sn', 'goods_name', 'goods_keys',  'desc', 'status', 'status_info', 'content', 'mobile_content'], 'safe'],
            [['old_price', 'price'], 'number'],
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
        $query = GoodsSeckill::find();

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
            'old_price' => $this->old_price,
            'price' => $this->price,
            'stock' => $this->stock,
            
          
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
