<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AdminLog;

/**
 * AdminLogSearch represents the model behind the search form about `common\models\AdminLog`.
 */
class AdminLogSearch extends AdminLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_log_id', 'user_id', 'created_at', 'event'], 'integer'],
            [['ip', 'info'], 'safe'],
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
        $query = AdminLog::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=>[
				'defaultOrder'=>[
					'user_log_id'=>SORT_DESC
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
            'user_log_id' => $this->user_log_id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'event' => $this->event,
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'info', $this->info]);

        return $dataProvider;
    }
}
