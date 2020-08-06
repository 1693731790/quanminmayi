<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserFeedback;

/**
 * UserFeedbackSearch represents the model behind the search form about `common\models\UserFeedback`.
 */
class UserFeedbackSearch extends UserFeedback
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['feedback_id', 'user_id'], 'integer'],
            [['phone', 'content'], 'safe'],
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
        $query = UserFeedback::find();

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
            'feedback_id' => $this->feedback_id,
            'user_id' => $this->user_id,
          
        ]);

        $query->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
