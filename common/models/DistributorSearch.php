<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Distributor;

/**
 * DistributorSearch represents the model behind the search form about `common\models\Distributor`.
 */
class DistributorSearch extends Distributor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['d_id', 'user_id', 'status', 'create_time'], 'integer'],
            [['balance'], 'number'],
            [['name', 'id_num', 'phone', 'company_name', 'address'], 'safe'],
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
        $query = Distributor::find();

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
            'd_id' => $this->d_id,
            'balance' => $this->balance,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'id_num', $this->id_num])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
