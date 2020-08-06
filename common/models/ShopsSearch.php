<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Shops;

/**
 * ShopsSearch represents the model behind the search form about `common\models\Shops`.
 */
class ShopsSearch extends Shops
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id', 'user_id', 'shop_sn', 'level', 'browse', 'status', 'create_time'], 'integer'],
            [['name', 'desc', 'truename', 'id_front', 'id_back', 'img', 'tel', 'address', 'notice', 'delivery_time'], 'safe'],
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
        $query = Shops::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'shop_id' => SORT_DESC,            
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
            
            'user_id' => $this->user_id,
            'shop_sn' => $this->shop_sn,
            'level' => $this->level,
            'browse' => $this->browse,
            'status' => $this->status,
            'create_time' => $this->create_time,
        ]);
		if($this->shop_id=="1")
        {
          	$query->andFilterWhere(['<>', 'shop_id', 1]);
        }else{
          	$query->andFilterWhere([ 'shop_id' => $this->shop_id]);
         
        }
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'truename', $this->truename])
            ->andFilterWhere(['like', 'id_front', $this->id_front])
            ->andFilterWhere(['like', 'id_back', $this->id_back])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'tel', $this->tel])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'notice', $this->notice])
            ->andFilterWhere(['like', 'delivery_time', $this->delivery_time]);

        return $dataProvider;
    }
}
