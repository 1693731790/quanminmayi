<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CallLog;

/**
 * CallLogCases represents the model behind the search form about `common\models\CallLog`.
 */
class CallLogSearch extends CallLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'call_time'], 'integer'],// 'start_time', 'end_time',
            [['caller', 'called'], 'string', 'max' =>11 ],
            [['guishudi', 'mobile_ip', 'openid', 'lon', 'lat', 'fee', 'balance'], 'safe'],
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
        $query = CallLog::find();

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
            'user_id' => $this->user_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'call_time' => $this->call_time,
        ]);
		$query->andFilterWhere(['like', 'caller', $this->caller])
            ->andFilterWhere(['like', 'guishudi', $this->guishudi])
            ->andFilterWhere(['like', 'mobile_ip', $this->mobile_ip])
            ->andFilterWhere(['like', 'openid', $this->openid])
            ->andFilterWhere(['like', 'lon', $this->lon])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'fee', $this->fee])
            ->andFilterWhere(['like', 'balance', $this->balance])
            ->andFilterWhere(['like', 'called', $this->called]);
        return $dataProvider;
    }
}
