<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%rob_buy}}".
 *
 * @property integer $rob_id
 * @property integer $shop_id
 * @property integer $goods_id
 * @property integer $num
 * @property string $price
 * @property integer $start_time
 * @property integer $end_time
 */
class RobBuy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rob_buy}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shop_id', 'goods_id', 'num', 'price', 'start_time', 'end_time'], 'required'],
            [['shop_id', 'goods_id', 'num', 'start_time', 'end_time'], 'integer'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rob_id' => 'ID',
            'shop_id' => '店铺ID',
            'goods_id' => '商品ID',
            'num' => '限购数量',
            'price' => '秒杀价格',
            'start_time' => '秒杀开始时间',
            'end_time' => '秒杀结束时间',
        ];
    }
    public function getGoods()
    {
        return $this->hasOne(Goods::className(), ["goods_id"=>"goods_id"]);
  
    }

}
