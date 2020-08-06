<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MobileCard;

/**
 * MobileCardSearch represents the model behind the search form about `common\models\MobileCard`.
 */
class MobileCardSearch extends MobileCard
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mid', 'create_time'], 'integer'],
            [['name', 'title_pic', 'desc'], 'safe'],
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
        $query = MobileCard::find();

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
            'mid' => $this->mid,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'title_pic', $this->title_pic])
            ->andFilterWhere(['like', 'desc', $this->desc]);

        return $dataProvider;
    }
}
