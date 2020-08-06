<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AgentBalanceRecord;

/**
 * AgentBalanceRecordSearch represents the model behind the search form about `common\models\AgentBalanceRecord`.
 */
class AgentBalanceRecordSearch extends AgentBalanceRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'agent_id', 'user_id', 'type', 'create_time'], 'integer'],
            [['fee'], 'number'],
            [['remarks'], 'safe'],
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
        $query = AgentBalanceRecord::find();

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
            'agent_id' => $this->agent_id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'fee' => $this->fee,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
