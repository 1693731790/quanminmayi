<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AfGoods;

/**
 * GoodsSearch represents the model behind the search form about `common\models\Goods`.
 */
class AfGoodsSearch extends AfGoods
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goods_id', 'shop_goods_id', 'status', 'create_time'], 'integer'],
            [['goods_sn', 'goods_name', 'goods_keys',  'goods_img', 'desc', 'content',], 'safe'],
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
        $query = AfGoods::find();

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
            'shop_goods_id' => $this->shop_goods_id,
            'cate_id1' => $this->cate_id1,
            'cate_id2' => $this->cate_id2,
            'cate_id3' => $this->cate_id3,
            'old_price' => $this->old_price,
            'price' => $this->price,
            'status' => $this->status,
           
        ]);

        $query->andFilterWhere(['like', 'goods_sn', $this->goods_sn])
            ->andFilterWhere(['like', 'goods_name', $this->goods_name])
            ->andFilterWhere(['like', 'goods_keys', $this->goods_keys])
            ->andFilterWhere(['like', 'goods_thums', $this->goods_thums])
            ->andFilterWhere(['like', 'desc', $this->desc]);

        return $dataProvider;
    }
}