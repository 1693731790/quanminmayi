<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{
    public $phone;

    public function rules()
    {
        return [
            [['id', 'parent_id', 'sex', 'age', 'integral', 'status', 'created_at','updated_at'], 'integer'],
            [['name', 'nickname', 'headimgurl', 'access_token', 'invitation_code', 'realname'], 'safe'],
            [['wallet'], 'number'],
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
        //$query = User::find()->joinWith('wxAuth');
		//$query = User::find()->with('phoneAuth');
        $query = User::find()->joinWith('phoneAuth');
 
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
            '{{%user}}.id' => $this->id,
            'parent_id' => $this->parent_id,
            'sex' => $this->sex,
            'age' => $this->age,
            'wallet' => $this->wallet,
            'integral' => $this->integral,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            '{{%user_auth}}.identifier' => $this->phone,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'headimgurl', $this->headimgurl])
            ->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'realname', $this->realname]);

        return $dataProvider;
    }
}
