<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MobileCardOrder;

/**
 * MobileCardOrderSearch represents the model behind the search form about `common\models\MobileCardOrder`.
 */
class MobileCardOrderSearch extends MobileCardOrder
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mo_id', 'partner_id', 'agent_id', 'mi_id', 'status', 'create_time'], 'integer'],
            [['morder_sn', 'phone', 'pay_img'], 'safe'],
            [['total_fee'], 'number'],
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
        $query = MobileCardOrder::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
          	'sort' => [
                'defaultOrder' => [
                    'mo_id' => SORT_DESC,            
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
            'mo_id' => $this->mo_id,
            'partner_id' => $this->partner_id,
            'agent_id' => $this->agent_id,
            'total_fee' => $this->total_fee,
            'mi_id' => $this->mi_id,
            'status' => $this->status,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'morder_sn', $this->morder_sn])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'pay_img', $this->pay_img]);

        return $dataProvider;
    }
}
