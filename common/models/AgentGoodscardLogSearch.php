<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AgentGoodscardLog;

/**
 * AgentGoodscardLogSearch represents the model behind the search form about `common\models\AgentGoodscardLog`.
 */
class AgentGoodscardLogSearch extends AgentGoodscardLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'out_agent_id', 'enter_agent_id', 'num', 'scFee', 'create_time'], 'integer'],
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
        $query = AgentGoodscardLog::find();

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
            'out_agent_id' => $this->out_agent_id,
            'enter_agent_id' => $this->enter_agent_id,
            'num' => $this->num,
            'scFee' => $this->scFee,
            'create_time' => $this->create_time,
        ]);

        return $dataProvider;
    }
}
