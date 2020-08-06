<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AfCodeLog;

/**
 * AfCodeLogSearch represents the model behind the search form about `common\models\AfCodeLog`.
 */
class AfCodeLogSearch extends AfCodeLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'code_id', 'user_id', 'type', 'create_time'], 'integer'],
            [['nickname', 'user_phone', 'address'], 'safe'],
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
        $query = AfCodeLog::find();

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
            'code_id' => $this->code_id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'user_phone', $this->user_phone])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
