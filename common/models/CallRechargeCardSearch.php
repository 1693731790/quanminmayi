<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CallRechargeCard;

/**
 * CallRechargeCardSearch represents the model behind the search form about `common\models\CallRechargeCard`.
 */
class CallRechargeCardSearch extends CallRechargeCard
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_use', 'fee', 'create_time',"end_time","call_agent_id"], 'integer'],
            [['batch_num', 'card_num', 'password',"user_id","phone"], 'safe'],
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
        $query = CallRechargeCard::find();

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
            'is_use' => $this->is_use,
            'fee' => $this->fee,
            'create_time' => $this->create_time,
            'end_time' => $this->end_time,
            'call_agent_id' => $this->call_agent_id,
          
        ]);

        $query->andFilterWhere(['like', 'batch_num', $this->batch_num])
            ->andFilterWhere(['like', 'card_num', $this->card_num])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'password', $this->password]);

        return $dataProvider;
    }
}
