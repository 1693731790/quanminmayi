<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\JdGoods;

/**
 * JdGoodsSearch represents the model behind the search form about `common\models\JdGoods`.
 */
class JdGoodsSearch extends JdGoods
{
  	public $marketPrice_min;
	public $marketPrice_max;
	public $retailPrice_min;
	public $retailPrice_max;
    public $profitPCT_min;
	public $profitPCT_max;
  
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'jdgoods_id', 'productCate', 'tax', 'orderSort', 'create_time'], 'integer'],
            [['name', 'brand', 'type', 'thumbnailImage', 'productCode', 'status', 'productPlace', 'features', 'imageUrl', 'content', 'mobile_content'], 'safe'],
            [['marketPrice', 'retailPrice',"profitPCT","marketPrice_min","marketPrice_max","retailPrice_min","retailPrice_max","profitPCT_min","profitPCT_max"], 'number'],
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
        $query = JdGoods::find();

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
            'id' => $this->id,
            'jdgoods_id' => $this->jdgoods_id,
            'productCate' => $this->productCate,
            'marketPrice' => $this->marketPrice,
            'retailPrice' => $this->retailPrice,
            'profitPCT' => $this->profitPCT,
            'tax' => $this->tax,
            'orderSort' => $this->orderSort,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'brand', $this->brand])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'thumbnailImage', $this->thumbnailImage])
            ->andFilterWhere(['like', 'productCode', $this->productCode])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'imageUrl', $this->imageUrl])
            ->andFilterWhere(['between', 'marketPrice',$this->marketPrice_min,$this->marketPrice_max])
            ->andFilterWhere(['between', 'retailPrice',$this->retailPrice_min,$this->retailPrice_max])
            ->andFilterWhere(['between', 'profitPCT',$this->profitPCT_min,$this->profitPCT_max]);

        return $dataProvider;
    }
  
     public function attributeLabels()
    {
    	return [
    			'marketPrice_min' => '京东价',
    			'marketPrice_max' => '-',
    			'retailPrice_min' => '协议价',
    			'retailPrice_max' => '-',
          		'profitPCT_min' => '利润',
    			'profitPCT_max' => '-',
    			
    	];
    }
}
