<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserCallfeeLog;

/**
 * UserCallfeeLogSearch represents the model behind the search form about `common\models\UserCallfeeLog`.
 */
class UserCallfeeLogSearch extends UserCallfeeLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'user_id'], 'integer'],
            [['fee'], 'number'],
            [['card_num', 'order_sn',"phone"], 'safe'],
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
        $query = UserCallfeeLog::find();

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
            'type' => $this->type,
            'user_id' => $this->user_id,
            'fee' => $this->fee,
        ]);

        $query->andFilterWhere(['like', 'card_num', $this->card_num])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'order_sn', $this->order_sn]);

        return $dataProvider;
    }
}
