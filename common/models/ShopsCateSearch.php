<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShopsCate;

/**
 * ShopsCateSearch represents the model behind the search form about `common\models\ShopsCate`.
 */
class ShopsCateSearch extends ShopsCate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'shop_id'], 'integer'],
            [['img', 'title'], 'safe'],
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
        $query = ShopsCate::find();

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
            'id' => $this->id,
            'shop_id' => $this->shop_id,
        ]);

        $query->andFilterWhere(['like', 'img', $this->img])

            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
