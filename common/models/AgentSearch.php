<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Agent;

/**
 * AgentSearch represents the model behind the search form about `common\models\Agent`.
 */
class AgentSearch extends Agent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['agent_id', 'user_id', 'parent_id', 'level', 'status', 'create_time'], 'integer'],
            [['id_num', 'id_front', 'id_back',"name"], 'safe'],
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
        $query = Agent::find();

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
            'agent_id' => $this->agent_id,
            'user_id' => $this->user_id,
            'parent_id' => $this->parent_id,
            'level' => $this->level,
           
            'status' => $this->status,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'id_num', $this->id_num])
            ->andFilterWhere(['like', 'id_front', $this->id_front])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'id_back', $this->id_back]);

        return $dataProvider;
    }
}
