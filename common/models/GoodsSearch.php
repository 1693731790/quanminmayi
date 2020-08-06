<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Goods;

/**
 * GoodsSearch represents the model behind the search form about `common\models\Goods`.
 */
class GoodsSearch extends Goods
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'shop_id', 'salecount', 'issale', 'ishot', 'isnew', 'status', 'create_time'], 'integer'],
            [['goods_sn', 'goods_name', 'goods_keys',  'goods_img', 'desc', 'content',"is_agent_buy","source","is_seckill"], 'safe'],
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
        $query = Goods::find()->where(["<>","status","-1"]);

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
            'shop_id' => $this->shop_id,
            "is_agent_buy"=>$this->is_agent_buy,
            'old_price' => $this->old_price,
            'price' => $this->price,
            'salecount' => $this->salecount,
            'issale' => $this->issale,
            'ishot' => $this->ishot,
            'isnew' => $this->isnew,
            'status' => $this->status,
            'source' => $this->source,
            'is_seckill' => $this->is_seckill,
          
          
        ]);

        $query->andFilterWhere(['like', 'goods_sn', $this->goods_sn])
            ->andFilterWhere(['like', 'goods_name', $this->goods_name])
            ->andFilterWhere(['like', 'goods_keys', $this->goods_keys])
            ->andFilterWhere(['like', 'goods_thums', $this->goods_thums])
            ->andFilterWhere(['like', 'goods_img', $this->goods_img])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
