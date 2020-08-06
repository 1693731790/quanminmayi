<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Wallet;

/**
 * WalletSearch represents the model behind the search form about `common\models\Wallet`.
 */
class WalletSearch extends Wallet
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wid', 'user_id', 'type', 'order_id', 'd_id', 'create_time'], 'integer'],
            [['fee', 'before_fee', 'after_fee'], 'number'],
            [['order_sn', 'd_sn','scale'], 'safe'],
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
        $query = Wallet::find();

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
            'wid' => $this->wid,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'fee' => $this->fee,
            'before_fee' => $this->before_fee,
            'after_fee' => $this->after_fee,
            'order_id' => $this->order_id,
            'd_id' => $this->d_id,
            'create_time' => $this->create_time,
            'scale' => $this->scale,
          
        ]);

        $query->andFilterWhere(['like', 'order_sn', $this->order_sn])
            ->andFilterWhere(['like', 'd_sn', $this->d_sn]);

        return $dataProvider;
    }
}
