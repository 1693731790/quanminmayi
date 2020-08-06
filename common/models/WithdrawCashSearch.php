<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\WithdrawCash;

/**
 * WithdrawCashSearch represents the model behind the search form about `common\models\WithdrawCash`.
 */
class WithdrawCashSearch extends WithdrawCash
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wid', 'type', 'user_id', 'bank_id', 'status', 'create_time', 'handle_time'], 'integer'],
            [['fee', 'real_fee'], 'number'],
            [['phone', 'remark'], 'safe'],
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
        $query = WithdrawCash::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'wid' => SORT_DESC,            
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
            'wid' => $this->wid,
            'type' => $this->type,
            'user_id' => $this->user_id,
            'fee' => $this->fee,
            'real_fee' => $this->real_fee,
            'bank_id' => $this->bank_id,
            'status' => $this->status,
            'create_time' => $this->create_time,
            'handle_time' => $this->handle_time,
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
