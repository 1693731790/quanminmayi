<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ShopsBanner;

/**
 * ShopsBannerSearch represents the model behind the search form about `common\models\ShopsBanner`.
 */
class ShopsBannerSearch extends ShopsBanner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['banner_id', 'shop_id', 'orderby'], 'integer'],
            [['img', 'url'], 'safe'],
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
        $query = ShopsBanner::find();

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
            'banner_id' => $this->banner_id,
            'shop_id' => $this->shop_id,
            'orderby' => $this->orderby,
        ]);

        $query->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
