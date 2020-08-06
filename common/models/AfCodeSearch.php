<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AfCode;

/**
 * AfCodeSearch represents the model behind the search form about `common\models\AfCode`.
 */
class AfCodeSearch extends AfCode
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'distributor_id', 'goods_id', 'status', 'create_time'], 'integer'],
            [['batch_num', 'number'], 'safe'],
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
        $query = AfCode::find();

        // add conditions that should always apply here
		 $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,            
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
            'id' => $this->id,
            'distributor_id' => $this->distributor_id,
            'goods_id' => $this->goods_id,
            'status' => $this->status,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'batch_num', $this->batch_num])
            ->andFilterWhere(['like', 'number', $this->number]);

        return $dataProvider;
    }
}
