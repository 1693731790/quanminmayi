<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\GoodsCategory;

/**
 * GoodsCategorySearch represents the model behind the search form about `common\models\GoodsCategory`.
 */
class GoodsCategorySearch extends GoodsCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cate_id', 'pid', 'level', 'sort'], 'integer'],
            [['name', 'cate_img', 'adv_img', 'adv_url'], 'safe'],
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
        $query = GoodsCategory::find();

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
            'cate_id' => $this->cate_id,
            'pid' => $this->pid,
            'level' => $this->level,
            'sort' => $this->sort,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'cate_img', $this->cate_img])
            ->andFilterWhere(['like', 'adv_img', $this->adv_img])
            ->andFilterWhere(['like', 'adv_url', $this->adv_url]);

        return $dataProvider;
    }
}
