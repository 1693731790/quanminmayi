<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AgentChannel;

/**
 * AgentChannelSearch represents the model behind the search form about `common\models\AgentChannel`.
 */
class AgentChannelSearch extends AgentChannel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_id', 'gt_fee', 'reward', 'proportion'], 'integer'],
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
        $query = AgentChannel::find();

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
            'channel_id' => $this->channel_id,
            'gt_fee' => $this->gt_fee,
            'reward' => $this->reward,
            'proportion' => $this->proportion,
        ]);

        return $dataProvider;
    }
}
